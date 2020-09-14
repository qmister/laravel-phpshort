<?php

namespace App\Observers;

use App\Domain;

class DomainObserver
{
    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Domain  $domain
     * @return void
     */
    public function deleting(Domain $domain)
    {
        // Delete all the related links, it needs to be called in
        // a loop, otherwise the delete() method won't trigger for the targeted model
        if (isset($domain->links))
        {
            foreach ($domain->links as $link) {
                $link->delete();
            }
        }
    }
}
