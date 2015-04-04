<?php namespace Jiro\Support\Validator;

/**
 * Validator trait.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

trait ValidatorTrait
{
    /**
     * The Validator instance.
     *
     * @var \Jiro\Support\Validators\Validator
     */
    protected $validator;

    /**
     * Returns the Validator instance.
     *
     * @return \Jiro\Support\Validators\Validator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Sets the Validator instance.
     *
     * @param  \Jiro\Support\Validators\Validator  $validator
     * @return $this
     */
    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;

        return $this;
    }
}
