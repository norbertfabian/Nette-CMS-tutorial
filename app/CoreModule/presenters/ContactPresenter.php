<?php
/**
 * Created by PhpStorm.
 * User: Norbert Fabian
 * Date: 14.03.2018
 * Time: 12:16
 */

namespace App\CoreModule\Presenters;


use App\Presenters\BasePresenter;
use Nette\Application\UI\Form;
use Nette\InvalidStateException;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;

class ContactPresenter extends BasePresenter
{

    const EMAIL = 'admin@localhost.cz';

    /**
     * @return Form
     */
    protected function createComponentContactForm()
    {
        $form = new Form;
        $form->addText('email', 'Vaše emailová adresa')->setType('email')->setRequired();
        $form->addText('y', 'Zadejte aktuální rok')->setRequired()
            ->addRule(Form::EQUAL, 'Chybně vyplněný antispam.', date("Y"));
        $form->addTextArea('message', 'Zpráva')->setRequired()
            ->addRule(Form::MIN_LENGTH, 'Zpráva musí být minimálně %d znaků dlouhá.', 10);
        $form->addSubmit('submit', 'Odeslat');
        $form->onSuccess[] = array($this, 'contactFormSucceeded');
        return $form;
    }

    /**
     * @param $form
     * @param $values
     * @throws \Nette\Application\AbortException
     */
    public function contactFormSucceeded($form, $values) {
        try {
            $mail = new Message();
            $mail->setFrom($values->email)
                ->addTo(self::EMAIL)
                ->setSubject('Email z webu')
                ->setBody($values->message);
            $mailer = new SendmailMailer();
            $mailer->send($mail);
            $this->flashMessage('Email byl úspěšně odeslán.');
            $this->redirect('this');
        } catch (InvalidStateException $ex) {
            $this->flashMessage('Email se nepodařilo odeslat.');
        }
    }
}