var client = new StringeeClient();
client.on('connect', function () {
    console.log('connected');
});
client.on('authen', function (res) {
    $('#loggedUserId').html(res.userId);
});
client.on('disconnect', function () {
    console.log('disconnected');
});
client.on('requestnewtoken', function () {
    console.log('++++++++++++++ requestnewtoken; please get new access_token from YourServer and call client.connect(new_access_token)+++++++++');
    //please get new access_token from YourServer and call:
    //client.connect(new_access_token);
});
function call_e(from, to) {
    var call = new StringeeCall(client, from, to, false);
    settingCallEvent(call);
    call.makeCall(function (res) {
        console.log('make call callback: ' + JSON.stringify(res));
    });
    client.on('incomingcall', function (incomingcall) {
        console.log('incomingcall', incomingcall);
    });
    call.answer(function (res) {
        console.log('answer res', res);
    });
    call.reject(function (res) {
        console.log('reject res', res);
    });
    client.on('incomingcall', function (incomingcall) {
        console.log('incomingcall', incomingcall);
        call = incomingcall;
        settingCallEvent(incomingcall);
        var answer = confirm('Incoming call from: ' + incomingcall.fromNumber + ', do you want to answer?');
        if (answer) {
            call.answer(function (res) {
                console.log('answer res', res);
            });
        } else {
            call.reject(function (res) {
                console.log('reject res', res);
            });
        }
    });
}
function settingCallEvent(call1) {
    call1.on('addremotestream', function (stream) {
        // reset srcObject to work around minor bugs in Chrome and Edge.
        console.log('addremotestream');
        remoteVideo.srcObject = null;
        remoteVideo.srcObject = stream;
    });

    call1.on('addlocalstream', function (stream) {
        // reset srcObject to work around minor bugs in Chrome and Edge.
        console.log('addlocalstream');
        localVideo.srcObject = null;
        localVideo.srcObject = stream;
    });

    call1.on('signalingstate', function (state) {
        console.log('signalingstate ', state);
        var reason = state.reason;
        $('#callStatus').html(reason);
    });

    call1.on('mediastate', function (state) {
        console.log('mediastate ', state);
    });

    call1.on('info', function (info) {
        console.log('on info:' + JSON.stringify(info));
    });
}