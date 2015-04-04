<?php namespace Jiro\Support\Traits;

trait MailerTrait
{
    /**
     * The Mailer instance.
     *
     * @var \Jiro\Support\Mailer
     */
    protected $mailer;

    /**
     * Returns the Mailer instance.
     *
     * @return \Cartalyst\Support\Mailer
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * Sets the Mailer instance.
     *
     * @param  \Jiro\Support\Mailer  $mailer
     * @return $this
     */
    public function setMailer(Mailer $mailer)
    {
        $this->mailer = $mailer;

        return $this;
    }
}
