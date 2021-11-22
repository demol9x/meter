$(document).ready(function() {
    "use strict";

    // js noUislider goi price

    var keypressSlider = document.getElementById('keypress');
    var input0 = document.getElementById('input-with-keypress-0');
    var input1 = document.getElementById('input-with-keypress-1');
    var inputs = [input0, input1];

    noUiSlider.create(keypressSlider, {
        start: [2600, 17200],
        connect: true,
        direction: 'ltr',
        range: {
            'min': [100, 300],
            'max': 30000
        },
        format: wNumb({
            decimals: 0,
            thousand: ',',
        })
    });

    keypressSlider.noUiSlider.on('update', function( values, handle ) {
        inputs[handle].value = values[handle];
    });
    function setSliderHandle(i, value) {
        var r = [null,null];
        r[i] = value;
        keypressSlider.noUiSlider.set(r);
    }

    // Listen to keydown events on the input field.
    inputs.forEach(function(input, handle) {

        input.addEventListener('change', function(){
            setSliderHandle(handle, this.value);
        });

        input.addEventListener('keydown', function( e ) {

            var values = keypressSlider.noUiSlider.get();
            var value = Number(values[handle]);

            // [[handle0_down, handle0_up], [handle1_down, handle1_up]]
            var steps = keypressSlider.noUiSlider.steps();

            // [down, up]
            var step = steps[handle];

            var position;

            // 13 is enter,
            // 38 is key up,
            // 40 is key down.
            switch ( e.which ) {

                case 13:
                    setSliderHandle(handle, this.value);
                    break;

                case 38:

                    // Get step to go increase slider value (up)
                    position = step[1];

                    // false = no step is set
                    if ( position === false ) {
                        position = 1;
                    }

                    // null = edge of slider
                    if ( position !== null ) {
                        setSliderHandle(handle, value + position);
                    }

                    break;

                case 40:

                    position = step[0];

                    if ( position === false ) {
                        position = 1;
                    }

                    if ( position !== null ) {
                        setSliderHandle(handle, value - position);
                    }

                    break;
            }
        });
    });
    // end js noUislider goi price

    // js noUislider goi CARAT

    var caratSlider = document.getElementById('carat');
    var inputcarat0 = document.getElementById('input-with-carat-0');
    var inputcarat1 = document.getElementById('input-with-carat-1');
    var inputscarat = [inputcarat0, inputcarat1];

    noUiSlider.create(caratSlider, {
        start: [2, 12],
        connect: true,
        direction: 'ltr',
        range: {
            'min': [0.25, 0.25],
            'max': 17.57
        },
    });

    caratSlider.noUiSlider.on('update', function( values, handle ) {
        inputscarat[handle].value = values[handle];
    });
    function setSliderHandle(i, value) {
        var r = [null,null];
        r[i] = value;
        caratSlider.noUiSlider.set(r);
    }

    // Listen to keydown events on the input field.
    inputscarat.forEach(function(inputcarat, handle) {

        inputcarat.addEventListener('change', function(){
            setSliderHandle(handle, this.value);
        });

        inputcarat.addEventListener('keydown', function( e ) {

            var values = caratSlider.noUiSlider.get();
            var value = Number(values[handle]);

            // [[handle0_down, handle0_up], [handle1_down, handle1_up]]
            var steps = caratSlider.noUiSlider.steps();

            // [down, up]
            var step = steps[handle];

            var position;

            // 13 is enter,
            // 38 is key up,
            // 40 is key down.
            switch ( e.which ) {

                case 13:
                    setSliderHandle(handle, this.value);
                    break;

                case 38:

                    // Get step to go increase slider value (up)
                    position = step[1];

                    // false = no step is set
                    if ( position === false ) {
                        position = 1;
                    }

                    // null = edge of slider
                    if ( position !== null ) {
                        setSliderHandle(handle, value + position);
                    }

                    break;

                case 40:

                    position = step[0];

                    if ( position === false ) {
                        position = 1;
                    }

                    if ( position !== null ) {
                        setSliderHandle(handle, value - position);
                    }

                    break;
            }
        });
    });
    // end js noUislider goi CARAT

    // begin js noUislider goi CUT
    var skipSlider_cut = document.getElementById('skipstep-cut');

    noUiSlider.create(skipSlider_cut, {
        range: {
            'min': 0,
            '20%': 20,
            '40%': 40,
            '60%': 60,
            '80%': 80,
            'max': 100
        },
        connect: [false, true, false],
        snap: true,
        start: [10, 90]
    });
    // end js noUislider goi CUT

    // begin js noUislider goi COLOR
    var skipSlider_color = document.getElementById('skipstep-color');

    noUiSlider.create(skipSlider_color, {
        range: {
            'min': 0,
            '14.2857%': 14.2857,
            '28.5714%': 28.5714,
            '42.8571%': 42.8571,
            '57.1428%': 57.1428,
            '71.4285%': 71.4285,
            '85.7142%': 85.7142,
            'max': 100
        },
        connect: [false, true, false],
        snap: true,
        start: [10, 90]
    });
    // end js noUislider goi COLOR

    // begin js noUislider goi CLARITY
    var skipSlider_clarity = document.getElementById('skipstep-clarity');

    noUiSlider.create(skipSlider_clarity, {
        range: {
            'min': 0,
            '14.2857%': 14.2857,
            '28.5714%': 28.5714,
            '42.8571%': 42.8571,
            '57.1428%': 57.1428,
            '71.4285%': 71.4285,
            '85.7142%': 85.7142,
            'max': 100
        },
        connect: [false, true, false],
        snap: true,
        start: [10, 90]
    });
    // end js noUislider goi CLARITY

    // js noUislider goi LENGTH TO WIDTH RATIO

    var legthRatio = document.getElementById('legth-ratio');
    var inputlegthRatio0 = document.getElementById('input-with-legthRatio-0');
    var inputlegthRatio1 = document.getElementById('input-with-legthRatio-1');
    var inputslegthRatio = [inputlegthRatio0, inputlegthRatio1];

    noUiSlider.create(legthRatio, {
        start: [2600, 17200],
        connect: true,
        direction: 'ltr',
        range: {
            'min': [100, 300],
            'max': 30000
        },
        format: wNumb({
            decimals: 0,
            thousand: ',',
        })
    });

    legthRatio.noUiSlider.on('update', function( values, handle ) {
        inputslegthRatio[handle].value = values[handle];
    });
    function setSliderHandle(i, value) {
        var r = [null,null];
        r[i] = value;
        legthRatio.noUiSlider.set(r);
    }

    // Listen to keydown events on the input field.
    inputslegthRatio.forEach(function(input, handle) {

        input.addEventListener('change', function(){
            setSliderHandle(handle, this.value);
        });

        input.addEventListener('keydown', function( e ) {

            var values = legthRatio.noUiSlider.get();
            var value = Number(values[handle]);

            // [[handle0_down, handle0_up], [handle1_down, handle1_up]]
            var steps = legthRatio.noUiSlider.steps();

            // [down, up]
            var step = steps[handle];

            var position;

            // 13 is enter,
            // 38 is key up,
            // 40 is key down.
            switch ( e.which ) {

                case 13:
                    setSliderHandle(handle, this.value);
                    break;

                case 38:

                    // Get step to go increase slider value (up)
                    position = step[1];

                    // false = no step is set
                    if ( position === false ) {
                        position = 1;
                    }

                    // null = edge of slider
                    if ( position !== null ) {
                        setSliderHandle(handle, value + position);
                    }

                    break;

                case 40:

                    position = step[0];

                    if ( position === false ) {
                        position = 1;
                    }

                    if ( position !== null ) {
                        setSliderHandle(handle, value - position);
                    }

                    break;
            }
        });
    });
    // end js noUislider goi LENGTH TO WIDTH RATIO

    // begin js noUislider goi POLISH
    var skipSlider_polish = document.getElementById('skipstep-polish');

    noUiSlider.create(skipSlider_polish, {
        range: {
            'min': 0,
            '33.3333%': 33.3333,
            '66.6666%': 66.6666,
            'max': 100
        },
        connect: [false, true, false],
        snap: true,
        start: [0, 66.6666]
    });
    // end js noUislider goi POLISH

    // begin js noUislider goi symmetry
    var skipSlider_symmetry = document.getElementById('skipstep-symmetry');

    noUiSlider.create(skipSlider_symmetry, {
        range: {
            'min': 0,
            '33.3333%': 33.3333,
            '66.6666%': 66.6666,
            'max': 100
        },
        connect: [false, true, false],
        snap: true,
        start: [0, 66.6666]
    });
    // end js noUislider goi symmetry

    // begin js noUislider goi fluorescence
    var skipSlider_fluorescence = document.getElementById('skipstep-fluorescence');

    noUiSlider.create(skipSlider_fluorescence, {
        range: {
            'min': 0,
            '20%': 20,
            '40%': 40,
            '60%': 60,
            '80%': 80,
            'max': 100
        },
        connect: [false, true, false],
        snap: true,
        start: [0, 50]
    });
    // end js noUislider goi fluorescence

    // js noUislider goi table

    var keypress_table = document.getElementById('keypress-table');
    var inputTable0 = document.getElementById('input-with-keypress-table-0');
    var inputTable1 = document.getElementById('input-with-keypress-table-1');
    var inputsTable = [inputTable0, inputTable1];

    noUiSlider.create(keypress_table, {
        start: [0, 70],
        connect: true,
        direction: 'ltr',
        range: {
            'min': 45,
            'max': 84
        },
    });
    keypress_table.noUiSlider.on('update', function( values, handle ) {
        inputsTable[handle].value = values[handle];
    });
    // end js noUislider goi table

    // js noUislider goi depth

    var keypress_depth = document.getElementById('keypress-depth');
    var inputDepth0 = document.getElementById('input-with-keypress-depth-0');
    var inputDepth1 = document.getElementById('input-with-keypress-depth-1');
    var inputsDepth = [inputDepth0, inputDepth1];

    noUiSlider.create(keypress_depth, {
        start: [0, 70],
        connect: true,
        direction: 'ltr',
        range: {
            'min': 45,
            'max': 84
        },
    });
    keypress_depth.noUiSlider.on('update', function( values, handle ) {
        inputsDepth[handle].value = values[handle];
    });
    // end js noUislider goi depth
});