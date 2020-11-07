<?php


namespace PhoneBurner\DNCScrub\Resources;


trait WithPhones
{
    public function withPhones(array $phone_list): self
    {
        $this->options['form_params']['phoneList'] = implode(',', $phone_list);
        return $this;
    }
}