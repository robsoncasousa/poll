<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poll;

class PollController extends Controller
{
    public function show($pollId)
    {
        $poll = Poll::findOrFail($pollId);
        $poll->increment('views');
        
        $data['poll_id'] = $poll->id;
        $data['poll_description'] = $poll->description;

        foreach($poll->options as $option)
        {
            $optionData = [];
            $optionData['option_id'] = $option->id;
            $optionData['option_description'] = $option->description;

            $data['options'][] = $optionData;
        }

        return $data;
    }

    public function store(Request $request)
    {
        $poll = new Poll;
        $poll->description = $request->get('poll_description');
        $poll->save();
        
        $options = $request->get('options');
        foreach ($options as $option)
        {
            $poll->options()->create([
                'description' => $option
            ]);
        }

        return ['poll_id' => $poll->id];
    }

    public function vote(Request $request, $pollId)
    {
        $poll = Poll::findOrFail($pollId);
        $optionId = $request->get('option_id');

        $option = $poll->options()->findOrFail($optionId);
        $option->increment('votes');
    }

    public function stats($pollId)
    {
        $poll = Poll::findOrFail($pollId);
        
        $data['views'] = $poll->views;

        foreach ($poll->options as $option) {
            $optionData = [];
            $optionData['option_id'] = $option->id;
            $optionData['qty'] = $option->votes;

            $data['votes'][] = $optionData;
        }

        return $data;
    }

}
