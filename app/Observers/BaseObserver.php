<?php

namespace App\Observers;

class BaseObserver
{
    public function created($model)
    {
        $this->clearCache();
    }

    public function updated($model)
    {
        // restore() triggering both restored() and updated()
        $this->clearCache();
    }

    public function deleted($model)
    {
        // delete() and forceDelete() will triggering deleted()
        $this->clearCache();
    }

    public function restored($model)
    {
        $this->clearCache();
    }

    protected function clearCache()
    {
    }
}