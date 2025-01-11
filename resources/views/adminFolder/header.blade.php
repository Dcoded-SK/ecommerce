    <div class="col-2 " style="border-right:3px white solid">

        <h3>Home</h3>

    </div>

    <div class="col-10 ">


        <div class="row">

            <div class="col-8 my-2">
                <h3 class="text-center">Management is the best skill! ({{ Auth::user()->name }})</h3>
            </div>
            <div class="col-4 ">
                <a href="/profile">
                    <h5 class="m-2 text-end"><img src="{{ asset('images/defaultuser.png') }}" alt=""></h5>
                </a>
            </div>
        </div>


    </div>
