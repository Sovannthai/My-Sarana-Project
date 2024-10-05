<style>
    .sidbar-chat {
        height: calc(100vh - 200px);
    }
</style>
<div class="col-lg-3 col-md-4 col-sm-12 sidbar-chat">
    <div class="chat-list bg-light-gray">
        <div class="chat-search">
            <span class="ti-search"></span>
            <input type="text" placeholder="Search Contact" />
        </div>
        <div class="notification-list chat-notification-list customscroll">
            <ul>
                @foreach ($row_chats as $row)
                    <li>
                        <a href="#">
                            <img src="{{ $row->avatar }}" alt="" />
                            <h3 class="clearfix">{{ $row->first_name }}</h3>
                            <p>
                                <i class="fa fa-circle text-light-green"></i> online
                            </p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
