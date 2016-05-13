@if (\Session::has('notification'))
    <div class="row">
        <div class="col-sm-12">

            <div class="msg-notifications">
                <div class="content">
                    {!! \Session::get('notification') !!}
                </div>
            </div>

        </div>
    </div>
@endif

@if (\Session::has('error'))
    <div class="row">
        <div class="col-sm-12">

            <div class="msg-errors">
                <div class="content">
                    {!! \Session::get('error') !!}
                </div>
            </div>

        </div>
    </div>
@endif

<div id="msgErrors"></div>
<div id="msgNotifications"></div>