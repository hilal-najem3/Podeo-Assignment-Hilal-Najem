<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Helpers\UploadOrGetFileHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PodcastAudio;
use App\Podcast;
use Auth;

class PodcastsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->canDo('read-podasts')) {
            $podcasts = Podcast::paginate(10);

            $data = [
                'podcasts' => $podcasts
            ];

            return view('admin.podcasts.index')->with($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->user()->canDo('create-podasts')) {
            $data = [
                'title' => 'Create New Podcast',
                'method' => 'POST',
                'submit' => route('podcasts.create.submit'),
                'button' => 'Create',
                'create' => true,
                'edit' => false
            ];
            return view('admin.podcasts.create-edit')->with($data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->user()->canDo('create-podasts')) {
            $podcast_data = $request->all();
            $podcast_data['admin_id'] = $request->user()->id;
            $this->validator($podcast_data)->validate();
            try {
                $podcast = Podcast::create($podcast_data);

                foreach ($request->file('podcast_file') as $podcast_file) {
                    $podcast_file_folder = 'podcasts/' . $request->user()->name();
                    $podcast_file_link = UploadOrGetFileHelper::saveFile($podcast_file, $podcast_file_folder);
                    PodcastAudio::create([
                        'podcast_id' => $podcast->id,
                        'link' => $podcast_file_link
                    ]);
                }

                return redirect()->route('podcasts.index')->with('message', 'Podcast Created');
            } catch (Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->user()->canDo('read-podasts')) {
            $podcast = Podcast::findorfail($id);
            $audio_files = $podcast->audios()->get();

            return view('admin.podcasts.show', compact('podcast', 'audio_files'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if ($request->user()->canDo('create-podasts')) {
            $podcast = Podcast::findorfail($id);
            $audio_files = $podcast->audios()->get();

            $data = [
                'podcast' => $podcast,
                'audio_files' => $audio_files,
                'title' => 'Update Podcast - ' . $podcast->id,
                'submit' => route('podcasts.update.submit', $podcast->id),
                'button' => 'Update',
                'method' => 'PUT',
                'create' => false,
                'edit' => true
            ];
            return view('admin.podcasts.create-edit')->with($data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->user()->canDo('create-podasts')) {
            $podcast = Podcast::findorfail($id);

            $podcast_data = $request->all();
            $podcast_data['admin_id'] = $request->user()->id;

            if(isset($podcast_data['podcast_file_changed'])) {
                if(getType($podcast_data['podcast_file_changed']) == 'string') {
                    if($podcast_data['podcast_file_changed'] == 'true') {
                        $podcast_data['podcast_file_changed'] = true;
                    } else {
                        $podcast_data['podcast_file_changed'] = false;
                    }
                }
            }

            if(isset($podcast_data['description_changed'])) {
                if(getType($podcast_data['description_changed']) == 'string') {
                    if($podcast_data['description_changed'] == 'true') {
                        $podcast_data['description_changed'] = true;
                    } else {
                        $podcast_data['description_changed'] = false;
                    }
                }
            }

            $this->validator($podcast_data, true)->validate();

            try {
                $podcast->title = $podcast_data['title'];
                if(isset($podcast_data['description_changed']) && $podcast_data['description_changed'] == true){
                    $podcast->description = $podcast_data['description'];
                }
                $podcast->admin_id = $podcast_data['admin_id'];
                $podcast->save();
                if($request->hasFile('podcast_file') && isset($podcast_data['podcast_file_changed']) && $podcast_data['podcast_file_changed'] == true) {
                    $audio_files = $podcast->audios()->get();
                    foreach($audio_files as $audio) {
                        UploadOrGetFileHelper::deleteFile($audio->link);
                        $audio->delete();
                    }
                    foreach ($request->file('podcast_file') as $podcast_file) {
                        $podcast_file_folder = 'podcasts/' . $request->user()->name();
                        $podcast_file_link = UploadOrGetFileHelper::saveFile($podcast_file, $podcast_file_folder);
                        PodcastAudio::create([
                            'podcast_id' => $podcast->id,
                            'link' => $podcast_file_link
                        ]);
                    }
                }

                return redirect()->route('podcasts.index')->with('message', 'Podcast Updated');
            } catch (Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->user()->canDo('create-podasts')) {
            $podcast = Podcast::findorfail($id);

            try {
                $audio_files = $podcast->audios()->get();
                foreach($audio_files as $audio) {
                    UploadOrGetFileHelper::deleteFile($audio->link);
                    $audio->delete();
                }
                $podcast->delete();

                return redirect()->route('podcasts.index')->with('message', 'Podcast deleted');
            } catch (Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @param  bool  $edit
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $edit = false)
    {
        $rules = [
            'title' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'admin_id' => ['nullable', 'exists:admins,id'],
        ];
        if($edit) {
            $rules['podcast_file'] = ['nullable'];
             $rules['podcast_file.*'] = ['nullable', 'file'];
            $rules['podcast_file_changed'] = ['nullable', 'boolean'];
        } else {
            $rules['podcast_file'] = ['required'];
            $rules['podcast_file.*'] = ['file'];
        }
        return Validator::make($data, $rules);
    }
}
