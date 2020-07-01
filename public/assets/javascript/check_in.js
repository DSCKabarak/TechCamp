var checkinApp = new Vue({
    el: '#app',
    data: {
        attendees: [],
        searchTerm: '',
        searchResultsCount: 0,
        showScannerModal: false,
        workingAway: false,
        isInit: false,
        isScanning: false,
        videoElement: $('video#scannerVideo')[0],
        canvasElement: $('canvas#QrCanvas')[0],
        scannerDataUrl: '',
        QrTimeout: null,
        canvasContext: $('canvas#QrCanvas')[0].getContext('2d'),
        successBeep: new Audio('/mp3/beep.mp3'),
        scanResult: false,
        scanResultObject: {}
    },

    created: function () {
        this.fetchAttendees()
    },

    ready: function () {
    },

    methods: {
        fetchAttendees: function () {
            this.$http.post(Attendize.checkInSearchRoute, {q: this.searchTerm}).then(function (res) {
                this.attendees = res.data;
                this.searchResultsCount = (Object.keys(res.data).length);
                console.log('Successfully fetched attendees')
            }, function () {
                console.log('Failed to fetch attendees')
            });
        },
        toggleCheckin: function (attendee) {

            if(this.workingAway) {
                return;
            }
            this.workingAway = true;
            var that = this;


            var checkinData = {
                checking: attendee.has_arrived ? 'out' : 'in',
                attendee_id: attendee.id,
            };

            this.$http.post(Attendize.checkInRoute, checkinData).then(function (res) {
                if (res.data.status == 'success' || res.data.status == 'error') {
                    if (res.data.status == 'error') {
                        alert(res.data.message);
                    }
                    attendee.has_arrived = checkinData.checking == 'out' ? 0 : 1;
                    that.workingAway = false;
                } else {
                    /* @todo handle error*/
                    that.workingAway = false;
                }
            });

        },
        clearSearch: function () {
            this.searchTerm = '';
            this.fetchAttendees();
        },

        /* QR Scanner Methods */

        QrCheckin: function (attendeeReferenceCode) {

            this.isScanning = false;

            this.$http.post(Attendize.qrcodeCheckInRoute, {attendee_reference: attendeeReferenceCode}).then(function (res) {
                this.successBeep.play();
                this.scanResult = true;
                this.scanResultObject = res.data;

            }, function (response) {
                this.scanResultObject.message = lang("whoops2");
            });
        },

        showQrModal: function () {
            this.showScannerModal = true;
            this.initScanner();
        },

        initScanner: function () {

            var that = this;
            this.isScanning = true;
            this.scanResult = false;

            /*
             If the scanner is already initiated clear it and start over.
             */
            if (this.isInit) {
                clearTimeout(this.QrTimeout);
                this.QrTimeout = setTimeout(function () {
                    that.captureQrToCanvas();
                }, 500);
                return;
            }

            qrcode.callback = this.QrCheckin;

            // FIX SAFARI CAMERA
            if (navigator.mediaDevices === undefined) {
                navigator.mediaDevices = {};
            }

            if (navigator.mediaDevices.getUserMedia === undefined) {
                navigator.mediaDevices.getUserMedia = function(constraints) {
                    var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

                    if (!getUserMedia) {
                        return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
                    }

                    return new Promise(function(resolve, reject) {
                        getUserMedia.call(navigator, constraints, resolve, reject);
                    });
                }
            }

            navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: "environment"
                },
                audio: false
            }).then(function(stream) {
                that.stream = stream;

                if (that.videoElement.mozSrcObject !== undefined) { // works on firefox now
                    that.videoElement.mozSrcObject = stream;
                } else if(window.URL) { // and chrome, but must use https
                    that.videoElement.srcObject = stream;
                };
            }).catch(function(err) {
                console.log(err.name + ": " + err.message);
                alert(lang("checkin_init_error"));
            });

            this.isInit = true;
            this.QrTimeout = setTimeout(function () {
                that.captureQrToCanvas();
            }, 500);
            
        },
        /**
         * Takes stills from the video stream and sends them to the canvas so
         * they can be analysed for QR codes.
         */
        captureQrToCanvas: function () {

            if (!this.isInit) {
                return;
            }

            this.canvasContext.clearRect(0, 0, 600, 300);

            try {
                this.canvasContext.drawImage(this.videoElement, 0, 0);
                try {
                    qrcode.decode();
                }
                catch (e) {
                    console.log(e);
                    this.QrTimeout = setTimeout(this.captureQrToCanvas, 500);
                }
            }
            catch (e) {
                console.log(e);
                this.QrTimeout = setTimeout(this.captureQrToCanvas, 500);
            }
        },
        closeScanner: function () {
            clearTimeout(this.QrTimeout);
            this.showScannerModal = false;
            track = this.stream.getTracks()[0];
            track.stop();
            this.isInit = false;
            this.fetchAttendees();
        }
    }
});
