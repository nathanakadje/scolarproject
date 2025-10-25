<?php

namespace App\Traits;

trait HasToastNotifications
{
    //
    public function toastsuccess($message)
    {
        $this->dispatch("toastr.success", message: $message);
    }

    public function toasterror($message)
    {
        $this->dispatch("toastr.error", message: $message);
    }
    public function toastwarning($message)
    {
        $this->dispatch("toastr.warning", message: $message);
    }

    public function toastinfo($message)
    {
        $this->dispatch("toastr.info", message: $message);
    }
}
