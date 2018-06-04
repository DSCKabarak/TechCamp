<script>
    function lang(key, params) {
        /* Line below will generate localization helpers warning, that it will not be included in search.
        * It is understandable, but I have no idea how to turn it off.*/
        var data = <?=json_encode(trans("Javascript"))?>;
        var string = data[key];
        if(typeof string == 'undefined')
            return key;
        for(var k in params) {
            string = string.split(":"+k).join(params[k]);
        }
        return string;
    }
</script>