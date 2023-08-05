<!DOCTYPE html>
<html>

<head>
    @include('home.css')

    <style type="text/css">
        .bg_comment {
            max-width: 200px
        }
    </style>
</head>

<body>

    @include("sweetalert::alert")

    <div class="hero_area">
        <!-- header section strats -->

        @include('home.header')
        <!-- end header section -->
        <!-- slider section -->
        @include('home.slider')
        <!-- end slider section -->
    </div>
    <!-- why section -->
    @include('home.why')
    <!-- end why section -->

    <!-- arrival section -->
    @include('home.new_arrival')
    <!-- end arrival section -->

    <!-- product section -->
    @include('home.product')

    <div style="text-align: center;">
        <h1 style="font-size:30px; padding-top:20px;
          padding-bottom: 20px;">Comments</h1>

        <form action="{{ url('add_comment') }}" method="POST">
            @csrf

            <textarea name="comment" style="height: 150px; width: 600px;" placeholder="Comment somethin here"></textarea><br>
            <input type="submit" class="btn btn-primary" value="Comment">
        </form>
    </div>

    <div style="padding-left: 30%;">
        <h1 style="font-size: 20px; padding-bottom:20px;">All Comments</h1>

        @foreach ($comment as $comment)
            <div style="margin-left: 20px;">
                <div class="bg_comment" style="background: rgb(211, 210, 210); padding:10px">
                    <b>{{ $comment->name }}</b>
                    <p>{{ $comment->comment }}</p>
                </div>
                <a style="color: blue; margin-left:20px;" href="javascript::void(0);" onclick="reply(this)"
                    data-Commentid="{{ $comment->id }}">Reply</a>

                @foreach ($reply as $replycomment)

                @if($replycomment->comment_id == $comment->id)

                    <div class="bg_comment"
                        style="
                            padding:10px; margin-left: 3%; margin-bottom:10px">
                        <b>{{ $replycomment->name }}</b>
                        <p>{{ $replycomment->reply }}</p>
                        <a style="color: blue; margin-left:20px;" href="javascript::void(0);"
                        onclick="reply(this)" data-Commentid="{{ $comment->id }}">Reply</a>
                    </div>
                    @endif
                @endforeach

            </div>
        @endforeach

            {{-- Reply Textbox --}}

        <div style="padding-left: 20px; display: none; margin-bottom:10px" class="replyDiv">
            <form action="{{ url('add_reply') }}" method="POST">
                @csrf

                <input type="text" name="commentId" id="commentId" hidden="">

                <textarea style="height: 50px; width: 500px;" placeholder="Write something here" name="reply"></textarea><br>

                <button type="submit" class="btn btn-warning">Reply</button>

                <a href="javascript::void(0);" class="btn" onclick="reply_close(this)">Close</a>
            </form>
        </div>

    </div>



    <script type="text/javascript">
        function reply(caller) {
            document.getElementById('commentId').value=$(caller).attr('data-CommentId');
            $('.replyDiv').insertAfter($(caller));
            $('.replyDiv').show();
        }

        function reply_close(caller) {

            $('.replyDiv').hide();
        }
    </script>

{{-- search come back --}}
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        var scrollpos = localStorage.getItem('scrollpos');
        if (scrollpos) window.scrollTo(0, scrollpos);
    });

    window.onbeforeunload = function(e) {
        localStorage.setItem('scrollpos', window.scrollY);
    };
</script>
{{-- end search come back --}}

    <!-- end product section -->

    <!-- subscribe section -->
    @include('home.subscribe')
    <!-- end subscribe section -->
    <!-- client section -->
    @include('home.client')
    <!-- end client section -->
    <!-- footer start -->
    @include('home.footer')
    <!-- footer end -->
    <div class="cpy_">
        <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

        </p>
    </div>
    <!-- jQery -->
    <script src="home/js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="home/js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="home/js/bootstrap.js"></script>
    <!-- custom js -->
    <script src="home/js/custom.js"></script>
</body>

</html>
