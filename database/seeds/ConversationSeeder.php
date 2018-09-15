<?php

use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // Conversation Group For Programs
        $programs = \App\Model\Programs::with([
                            'user.profile',
                            'coach.profile',
                            'nutrition_doctor.profile',
                            'corrective_doctor.profile'])
                            ->where('status','!=','orphan')
                            ->take(5)
                            ->get();


        foreach ($programs as $program)
        {
            $read_status = [
                $program->user->id => false,
                $program->coach->id => false,
                $program->nutrition_doctor->id => false,
                $program->corrective_doctor->id => false
            ];

            $conversation = new \App\Model\Conversation();
            $conversation->title = 'گروه گفتگو';
            $conversation->program_id= $program->id;
            $conversation->type = 'group';
            $conversation->read_status = $read_status;
            $conversation->save();

            $conversation->user()->attach([$program->user->id,$program->coach->id,$program->nutrition_doctor->id,$program->corrective_doctor->id]);

            $message = new \App\Model\Message();
            $message->conversation_id = $conversation->id;
            $message->user_id = $program->user->id;
            $message->text = 'Hi!';
            $message->attachment = 'text';
            $message->save();

            $message = new \App\Model\Message();
            $message->conversation_id = $conversation->id;
            $message->user_id = $program->coach->id;
            $message->text = 'How Are You?';
            $message->attachment = 'text';
            $message->save();

            $message = new \App\Model\Message();
            $message->conversation_id = $conversation->id;
            $message->user_id = $program->nutrition_doctor->id;
            $message->text = 'Hi every one?';
            $message->attachment = 'text';
            $message->save();

            $message = new \App\Model\Message();
            $message->conversation_id = $conversation->id;
            $message->user_id = $program->corrective_doctor->id;
            $message->text = 'Are you ready?';
            $message->attachment = 'text';
            $message->save();

            // Private Conversation
            $read_status = [
                $program->user->id => false,
                $program->coach->id => false,
            ];

            $conversation = new \App\Model\Conversation();
            $conversation->title = 'گفتگوی خصوصی';
            $conversation->type = 'private';
            $conversation->read_status = $read_status;
            $conversation->started_by = $program->user->id;
            $conversation->save();

            $conversation->user()->attach([$program->user->id,$program->coach->id]);

            $message = new \App\Model\Message();
            $message->conversation_id = $conversation->id;
            $message->user_id = $program->user->id;
            $message->text = 'Hi!';
            $message->attachment = 'text';
            $message->save();

            $message = new \App\Model\Message();
            $message->conversation_id = $conversation->id;
            $message->user_id = $program->coach->id;
            $message->text = 'How Are You?';
            $message->attachment = 'text';
            $message->save();


        }




    }
}
