<?php
/**
 * Created by PhpStorm.
 * User: Norbert Fabian
 * Date: 14.03.2018
 * Time: 11:01
 */

namespace App\CoreModule\Presenters;

use App\CoreModule\Model\ArticleManager;
use App\Presenters\BasePresenter;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Form;
use Nette\Database\UniqueConstraintViolationException;


class ArticlePresenter extends BasePresenter
{

    const DEFAULT_ARTICLE_URL = 'uvod';

    protected $articleManager;

    /**
     * ArticlePresenter constructor.
     * @param ArticleManager $articleManager
     */
    public function __construct(ArticleManager $articleManager)
    {
        parent::__construct();
        $this->articleManager = $articleManager;
    }

    /**
     * @param $url
     * @throws BadRequestException
     */
    public function renderDefault($url)
    {
        if (!$url) $url = self::DEFAULT_ARTICLE_URL;

        if (!($article = $this->articleManager->getArticle($url))) throw new BadRequestException();
        $this->template->article = $article;
    }


    public function renderList()
    {
        $this->template->articles = $this->articleManager->getArticles();
    }

    public function actionRemove($url)
    {
        $this->articleManager->removeArticle($url);
        $this->flashMessage('Článek byl úspěšně odstraněn.');
        $this->redirect(':Core:Article:list');
    }

    /**
     * @param $url
     */
    public function actionEditor($url)
    {
        if ($url)
            ($article = $this->articleManager->getArticle($url)) ? $this['editorForm']->setDefaults($article) : $this->flashMessage('Článek nebyl nalezen.');
    }


    /**
     * @return Form
     */
    protected function createComponentEditorForm()
    {
        $form = new Form();
        $form->addHidden('article_id');
        $form->addText('title', 'Titulek')->setRequired();
        $form->addText('url', 'URL')->setRequired();
        $form->addText('description', 'Popisek')->setRequired();
        $form->addTextArea('content', 'obsah');
        $form->addSubmit('submit', 'Uložit článek');
        $form->onSuccess[] = array($this, 'editorFormSucceeded');
        return $form;
    }

    /**
     * @param $form
     * @param $values
     * @throws \Nette\Application\AbortException
     */
    public function editorFormSucceeded($form, $values)
    {
        try {
            $this->articleManager->saveArticle($values);
            $this->flashMessage('Článek byl úspěšně uložen.');
            $this->redirect(':Core:Article:', $values->url);
        } catch (UniqueConstraintViolationException $ex) {
            $this->flashMessage('Článek s touto URL adresou již existuje.');
        }
    }

}