##  A Realtime ChatRoom Demo build with Laravel 5.4 + vue 2
## Steps:

### 1.创建event

> php artisna make:event MessagePosted

db message 保存成功后，使用event(new EventClass())

### 2.Pusher

#### 2.1注册pusher

>app_id = "269039"
>key = ""
>secret = ""
>cluster = "mt1"

#### 2.2 app.php
取消 App\Providers\BroadcastServiceProvider::class, 的注释

### 3 laravel event broadcasting 服务
[文档](http://d.laravel-china.org/docs/5.4/broadcasting)
##!! 注意laravel5.4，要在config/app.php添加一条aliase: 'Pusher' => Pusher\Pusher::class, 否则系统找不到Pusher !!

安装需要的一些前后端 package
#### 3.1 添加pusher后端服务组件
> composer require pusher/pusher-php-server


#### 3.2 添加 echo , laravel前端服务组件
打开 /resources/assets/js/bootstrap.js
取消以下内容注释，激活echo js组件

````
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: "pusher",
    key: "",
    cluster: "mt1",
    encrypted: false
});

````
#### 3.3安装前端js组件
(Laravel Echo 是一个 JavaScript 库，可以订阅频道和监听由 Laravel 广播的事件)
> npm install --save laravel-echo pusher-js

#### 3.4 前端接收广播
在页面js中的代码： (使用private频道，也可参考 Presence 频道 )
````
Echo.private('ashuchatroom')
    .listen('MessagePosted', (event) => {
    // handle event
    console.log("test echo", event);
});
````

#### 3.5编辑event文件： MessagePosted.php

````
class MessagePosted implements ShouldBroadcast
{
    public $message;
    public $user;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(Message $message, User $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('ashuchatroom'); // 与前端channel名称一致
    }
}

````

#### 3.6 编辑路由 /routes/channels.php , 添加路由后才能授权用户使用广播
````
Broadcast::channel('ashuchatroom', function () {
    return true;
});
````

#### 3.7添加broadcast路由至 api.php
````
Broadcast::routes(['middleware' => ['web', 'auth']]);
````


----
ashucn@gmail.com


