<?php

namespace Takshak\Adash\Actions;

class FaqAction
{
	public function save($request, $faq)
	{
		$faq->question  =   $request->post('question');
		$faq->pref      =   $request->post('pref');
		$faq->status    =   $request->post('status');
		$faq->answer    =   $request->post('answer');
		$faq->save();

		return $faq;
	}
}