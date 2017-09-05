<?php

namespace PCLab\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use PCLab\Compatibility\Contracts\SelectionContract;

class OrderSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /** @var SelectionContract $selection */
    private $selection;

    /** @var string $mailto */
    private $mailto;

    public function __construct(SelectionContract $selection, string $mailto)
    {
        $this->selection = $selection;
        $this->mailto = $mailto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('emails.orders.submitted')->with([
            'selection' => $this->selection->getAll(),
            'mailto' => $this->mailto,
        ]);
    }
}
