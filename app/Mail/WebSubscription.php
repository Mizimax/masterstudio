<?php

	namespace App\Mail;

	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;

	class WebSubscription extends Mailable
	{
		use Queueable, SerializesModels;

		public $description;
		public $subject;

		/**
		 * Create a new message instance.
		 *
		 * @return void
		 */
		public function __construct($subject, $description)
		{
			//
			$this->description = $description;
			$this->subject = $subject;
		}

		/**
		 * Build the message.
		 *
		 * @return $this
		 */
		public function build()
		{
//			$result =  $this->from('support@atmasterstudio.com', '@Masterstudio')
//				->view('mails.mail')
//				->with([
//					'html' => $this->html
//				]);
//			foreach($this->attachFiles as $file) {
//				$result = $result->attach('/path/', 'name.pdf');
//			}
			return $this->from('support@atmasterstudio.com', '@Masterstudio')
				->subject($this->subject)
				->with(['message' => $this])
				->view('mails.mail');
		}
	}
