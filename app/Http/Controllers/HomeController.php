<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use DB;
use notify;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
use Carbon\Carbon;
use File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $is_l = DB::table('reactions')->select('from_uid as fd', 'post_id')->where('from_uid', Auth::id());
        $rec = DB::table('reactions')->selectRaw('count(*) as like_count, post_id')->groupBy('post_id');
        $frnd = DB::table('friend_reqs')->select('from as uid')->where('to', Auth::id())->where('accepted', 1);
        $me = DB::table('users')->select('uid')->where('uid', Auth::id());
        $all_frnd = DB::table('friend_reqs')->select('to as uid')->where('from', Auth::id())->where('accepted', 1)->union($frnd)->union($me);
        $posts = DB::table('posts')->distinct()
            // ->where('user_id', Auth::id())

            ->select('name', 'users.uid', 'posts.created_at', 'post_image', 'post_caption', 'posts.pid', 'like_count', 'fd', 'pro_pic', 'gender')
            //->select('*')
            //->selectRaw('name,posts.created_at,post_image,post_caption,posts.pid,like_count,exists(fd)')
            ->leftJoinSub($rec, 'rec', function ($join) {
                $join->on('rec.post_id', '=', 'posts.pid');
            })
            ->join('users', 'users.uid', '=', 'posts.user_id')
            ->joinSub($all_frnd, 'frnds', function ($join) {
                $join->on('frnds.uid', '=', 'users.uid');
            })
            ->leftJoinSub($is_l, 'is_l', function ($join) {
                $join->on('is_l.post_id', '=', 'posts.pid');
            })
            ->orderBy('posts.created_at', 'desc')
            ->get();
        //return $comment;
        return view('home', compact('posts'));
    }

    public function profile()
    {
        $is_l = DB::table('reactions')->select('from_uid as fd', 'post_id')->where('from_uid', Auth::id());
        $rec = DB::table('reactions')->selectRaw('count(*) as like_count, post_id')->groupBy('post_id');
        $posts = DB::table('posts')
            ->where('user_id', Auth::id())
            ->select('uid', 'name', 'gender', 'posts.created_at', 'post_image', 'post_caption', 'posts.pid', 'like_count', 'fd', 'pro_pic')
            //->select('*')
            //->selectRaw('name,posts.created_at,post_image,post_caption,posts.pid,like_count,exists(fd)')
            ->leftJoinSub($rec, 'rec', function ($join) {
                $join->on('rec.post_id', '=', 'posts.pid');
            })
            ->join('users', 'users.uid', '=', 'posts.user_id')
            ->leftJoinSub($is_l, 'is_l', function ($join) {
                $join->on('is_l.post_id', '=', 'posts.pid');
            })

            ->orderBy('posts.created_at', 'desc')
            ->get();
        $user = DB::table('users')->where('uid', Auth::id())->first();
        $frnd = DB::table('friend_reqs')->select('from as uid')->where('to', Auth::id())->where('accepted', 1);
        $all_frnd = DB::table('friend_reqs')->select('to as uid')->where('from', Auth::id())->where('accepted', 1)->union($frnd);
        $users_frnd = DB::table('users')->joinSub($all_frnd, 'frnds', function ($join) {
            $join->on('frnds.uid', '=', 'users.uid');
        })->get();
        return view('profile', compact('posts', 'user', 'users_frnd'));
        //return $posts;
        //return($likes);
    }
    public function edit_profile()
    {
        $user = DB::table('users')->where('uid', Auth::id())->first();
        return view('edit_profile', compact('user'));
    }
    public function update_profile(Request $request)
    {
        DB::table('users')->where('uid', Auth::id())->update(['bio' => $request->bio, 'work' => $request->work, 'study' => $request->study]);
        return redirect('/profile');
    }

    public function friends()
    {
        $frnd = DB::table('friend_reqs')->select('from as uid')->where('to', Auth::id())->where('accepted', 1);
        $all_frnd = DB::table('friend_reqs')->select('to as uid')->where('from', Auth::id())->where('accepted', 1)->union($frnd);
        $users = DB::table('users')->joinSub($all_frnd, 'frnds', function ($join) {
            $join->on('frnds.uid', '=', 'users.uid');
        })->get();
        $user = DB::table('users')->where('uid', Auth::id())->first();
        //return $users;
        return view('friends', compact('users', 'user'));
    }

    public function account($id)
    {
        if (Auth::id() == $id)
            return redirect('/profile');

        $user = DB::table('users')->where('uid', $id)->first();
        $code = 3;
        if (DB::table('friend_reqs')->where([['from', Auth::id()], ['to', $id]])->exists()) {
            $freq_sent = DB::table('friend_reqs')->where([['from', Auth::id()], ['to', $id]])->first();
            if ($freq_sent->accepted) {
                $code = 2;
            } else {
                $code = 0;
            }
        }
        if (DB::table('friend_reqs')->where([['to', Auth::id()], ['from', $id]])->exists()) {
            $freq_got = DB::table('friend_reqs')->where([['to', Auth::id()], ['from', $id]])->first();
            if ($freq_got->accepted) {
                $code = 2;
            } else {
                $code = 1;
            }
        }
        $is_l = DB::table('reactions')->select('from_uid as fd', 'post_id')->where('from_uid', Auth::id());
        $rec = DB::table('reactions')->selectRaw('count(*) as like_count, post_id')->groupBy('post_id');
        $posts = DB::table('posts')
            ->where('user_id', $id)
            ->select('name', 'users.uid', 'gender', 'posts.created_at', 'post_image', 'post_caption', 'posts.pid', 'like_count', 'fd', 'pro_pic')
            //->select('*')
            //->selectRaw('name,posts.created_at,post_image,post_caption,posts.pid,like_count,exists(fd)')
            ->leftJoinSub($rec, 'rec', function ($join) {
                $join->on('rec.post_id', '=', 'posts.pid');
            })
            ->join('users', 'users.uid', '=', 'posts.user_id')
            ->leftJoinSub($is_l, 'is_l', function ($join) {
                $join->on('is_l.post_id', '=', 'posts.pid');
            })
            ->orderBy('posts.created_at', 'desc')
            ->get();
        $frnd = DB::table('friend_reqs')->select('from as uid')->where('to', $id)->where('accepted', 1);
        $all_frnd = DB::table('friend_reqs')->select('to as uid')->where('from', $id)->where('accepted', 1)->union($frnd);
        $users_frnd = DB::table('users')->joinSub($all_frnd, 'frnds', function ($join) {
            $join->on('frnds.uid', '=', 'users.uid');
        })->get();

        return view('account', compact('user', 'code', 'posts', 'users_frnd'));
       //print_r($user);
    }

    public function account_friends($id)
    {
        if (Auth::id() == $id)
            return redirect('/friends');

        $user = DB::table('users')->where('uid', $id)->first();
        $code = 3;
        if (DB::table('friend_reqs')->where([['from', Auth::id()], ['to', $id]])->exists()) {
            $freq_sent = DB::table('friend_reqs')->where([['from', Auth::id()], ['to', $id]])->first();
            if ($freq_sent->accepted) {
                $code = 2;
            } else {
                $code = 0;
            }
        }
        if (DB::table('friend_reqs')->where([['to', Auth::id()], ['from', $id]])->exists()) {
            $freq_got = DB::table('friend_reqs')->where([['to', Auth::id()], ['from', $id]])->first();
            if ($freq_got->accepted) {
                $code = 2;
            } else {
                $code = 1;
            }
        }
        $frnd = DB::table('friend_reqs')->select('from as uid')->where('to', $id)->where('accepted', 1);
        $all_frnd = DB::table('friend_reqs')->select('to as uid')->where('from', $id)->where('accepted', 1)->union($frnd);
        $users = DB::table('users')->joinSub($all_frnd, 'frnds', function ($join) {
            $join->on('frnds.uid', '=', 'users.uid');
        })->get();


        return view('friends_acc', compact('user', 'code', 'users'));
    }

    function fetch(Request $request)
    {
        if ($request->get('term')) {
            $query = $request->get('term');
            $data = DB::table('users')->where('name', 'LIKE', "%{$query}%")->get();


            if ($data->isEmpty()) {
                // echo "TRUE";
                echo json_encode([array("value" => "#", "label" => "No result found")]);
                exit;
            }
            $response = array();
            foreach ($data as $dat) {
                $response[] = array("value" => $dat->uid, "label" => $dat->name);
            }


            echo json_encode($response);
        }
    }

    function send_freq(Request $request)
    {
        $succ = DB::table('friend_reqs')->updateOrInsert(['from' => $request->from, 'to' => $request->to, 'created_at' => Carbon::now()]);
        if ($succ) {
            echo json_encode("success");
            // pusher
            $options = array(
                'cluster' => 'ap2',
                'useTLS' => true
            );

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );
            $name = DB::table('users')->where('uid', $request->from)->first();
            $data = ['from' => $name->name, 'to' => $request->to];
            $pusher->trigger('friend_req', 'req_sent', $data);
        } else {
            echo json_encode("failed");
        }
    }

    function accept_freq(Request $request)
    {
        $suc = DB::table('friend_reqs')->where([['to', $request->to], ['from', $request->from]])->update(['accepted' => 1]);
        if ($suc) {
            echo json_encode("success");
        } else {
            echo json_encode("failed");
        }
    }

    function delete_freq(Request $request)
    {
        $suc = DB::table('friend_reqs')->where([['to', $request->to], ['from', $request->from]])->delete();
        if ($suc) {
            echo json_encode("success");
        } else {
            echo json_encode("failed");
        }
    }

    function get_frq(Request $request)
    {
        $suc = DB::table('friend_reqs')->where('to', $request->id)->where('accepted', 0)->join('users', 'users.uid', '=', 'from')->orderBy('friend_reqs.created_at', 'desc')->get();
        return view('friend_req.index', ['users' => $suc]);
    }

    function get_notify(Request $request)
    {
        $suc = DB::table('notification')->where('to_uid', $request->id)->join('users', 'users.uid', '=', 'from_uid')->join('posts', 'posts.pid', '=', 'post_id')->orderBy('notification.created_at', 'desc')->get();
        DB::table('notification')->where('to_uid', $request->id)->update(['is_read'=>'1']);
        return view('layouts.notify.index', ['users' => $suc]);
    }

    function get_frq_pen(Request $request)
    {
        $suc = array();
        $frnd = DB::table('friend_reqs')->where('to', $request->id)->where('accepted', 0)->join('users', 'users.uid', '=', 'from')->get();
        $noti = DB::table('notification')->where('to_uid', $request->id)->where('is_read', 0)->get();
        $msg = DB::table('messages')->where('to', $request->id)->where('is_read', 0)->get();
        $suc[0] = count($frnd);
        $suc[1] = count($noti);
        $suc[2] = count($msg);
        return $suc;
    }

    public function messanger()
    {
        // select all users except logged in user
        // $users = User::where('id', '!=', Auth::id())->get();
        $id = Auth::id();
        $frnd = DB::table('friend_reqs')->select('from as uid')->where('to', $id)->where('accepted', 1);
        $all_frnd = DB::table('friend_reqs')->select('to as uid')->where('from', $id)->where('accepted', 1)->union($frnd);
        // count how many message are unread from the selected user
        // $users = DB::select("select users.uid, users.name, users.pro_pic , users.email, users.gender,count(is_read) as unread 
        // from users LEFT  JOIN  messages ON users.uid = messages.from and is_read = 0 and messages.to = " . Auth::id() . " 
        // where users.uid != " . Auth::id() . " 
        // group by users.uid, users.name, users.pro_pic, users.email,users.gender");
        
        $users = DB::table('users')->selectRaw('users.uid ,users.name, users.pro_pic , users.email, count(is_read) as unread,users.gender')
        ->joinSub($all_frnd, 'frnds', function ($join) {
            $join->on('frnds.uid', '=', 'users.uid');
        })
        ->leftJoin('messages', function ($join) {
            $join->on('users.uid', '=', 'messages.from')
            ->where('is_read','=','0')
            ->where('messages.to','=', Auth::id());
            //->where('users.uid','=',Auth::id());
        })
        ->groupBy( 'users.uid','users.name', 'users.pro_pic', 'users.email','users.gender')
        ->get();
        //return $users;
        return view('messanger', ['users' => $users]);
    }

    public function getMessage($user_id)
    {
        $my_id = Auth::id();

        // Make read all unread message
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        // Get all message from selected user
        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->where('to', $my_id);
        })->oRwhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->where('to', $user_id);
        })->get();

        return view('messages.index', ['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0; // message will be unread when sending message
        $data->save();

        // pusher
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to, 'fname' => Auth::user()->name, 'message' => $message]; // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);
    }

    public function imageUpload()
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('img/' . str_replace(' ', '_', strtolower(Auth::user()->name))), $imageName);
        DB::table('posts')->insert([['post_image' => $imageName, 'post_caption' => request()->caption, 'user_id' => Auth::id(), 'created_at' => Carbon::now()]]);
        return back()->with('success', 'You have successfully created post.');
    }

    public function uploadCover()
    {
        request()->validate([
            'coverimg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = 'cover.' . request()->coverimg->getClientOriginalExtension();
        request()->coverimg->move(public_path('img/' . str_replace(' ', '_', strtolower(Auth::user()->name))), $imageName);
        DB::table('users')->where('uid', Auth::id())->update(['cover_pic' => $imageName]);
        return back()->with('success', 'You have successfully update your cover pic.');
    }

    public function uploadpro()
    {
        request()->validate([
            'proimg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = 'pro.' . request()->proimg->getClientOriginalExtension();
        request()->proimg->move(public_path('img/' . str_replace(' ', '_', strtolower(Auth::user()->name))), $imageName);
        DB::table('users')->where('uid', Auth::id())->update(['pro_pic' => $imageName]);
        return back()->with('success', 'You have successfully update your Profile pic.');
    }

    public function del_post($pid)
    {
        $img = DB::table('posts')->where('pid', $pid)->first();
        unlink(public_path('/img/' . str_replace(' ', '_', strtolower(Auth::user()->name)) . '/' . $img->post_image));
        DB::table('posts')->where('pid', $pid)->delete();
        return back()->with('success', 'Post Deleted Successfully.');
    }

    public function lik_post(Request $request)
    {
        $from = $request->from;
        $pid = $request->pid;
        $post = DB::table('posts')->where('pid', $pid)->first();
        DB::table('reactions')->insert(['from_uid' => $from, 'to_uid' => $post->user_id, 'post_id' => $post->pid, 'created_at' => Carbon::now()]);
        $user = DB::table('users')->where('uid', $from)->first();
        $notice = $user->name . " liked your post";
        if ($from != $post->user_id) {
            DB::table('notification')->insert(['from_uid' => $from, 'to_uid' => $post->user_id, 'post_id' => $post->pid, 'notice' => $notice, 'created_at' => Carbon::now()]);
            $options = array(
                'cluster' => 'ap2',
                'useTLS' => true
            );

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );
            $data = ['from' => $user->name, 'to' => $post->user_id,'note' => "Doesn't mean they like you",'pid'=>$pid,'like'=>'1'];
            $pusher->trigger('notify', 'noti', $data);
        }
        echo json_encode("success");
    }

    public function dislik_post(Request $request)
    {
        $from = $request->from;
        $pid = $request->pid;
        DB::table('reactions')->where('post_id', $pid)->where('from_uid', $from)->delete();
        echo json_encode("success");
    }

    public function comment(Request $request)
    {
        $from = $request->from;
        $comment = $request->comment;
        $pid = explode("_", $request->pid)[1];
        $to = DB::table('posts')->where('pid', $pid)->first();
        //return $to;
        DB::table('comments')->insert(['comment' => $comment, 'from_uid' => $from, 'to_uid' => $to->user_id, 'post_id' => $pid, 'created_at' => Carbon::now()]);
        $user = DB::table('users')->where('uid', $from)->first();
        $notice = $user->name . " commented your post <br/>" . $comment;
        if ($from != $to->user_id)
        {
            DB::table('notification')->insert(['from_uid' => $from, 'to_uid' => $to->user_id, 'post_id' => $pid, 'notice' => $notice, 'created_at' => Carbon::now()]);
            $options = array(
                'cluster' => 'ap2',
                'useTLS' => true
            );

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );
            $data = ['from' => $user->name, 'to' => $to->user_id,'note' => $comment,'pid'=>$pid,'like'=>'0'];
            $pusher->trigger('notify', 'noti', $data);
        }
        $comm = DB::table('comments')->where('post_id', $pid)->join('users', 'users.uid', '=', 'from_uid')->orderBy('comments.created_at', 'desc')->get();
        return view('comment.index', compact('comm'));
    }

    public function get_comment(Request $request)
    {
        $comm = DB::table('comments')->where('post_id', $request->pid)->join('users', 'users.uid', '=', 'from_uid')->orderBy('comments.created_at', 'desc')->get();
        return view('comment.index', compact('comm'));
    }


    public function liked_by(Request $request)
    {
        $lik = DB::table('reactions')->where('post_id', $request->pid)->join('users', 'users.uid', '=', 'from_uid')->orderBy('reactions.created_at', 'desc')->get();
        return view('liked_by.index', compact('lik'));
    }
}
