/*
 * Emoji plugin for summernote [https://github.com/summernote/summernote]
 * Canonical - https://github.com/nilobarp/summernote-ext-emoji
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else {
        factory(window.jQuery);
    }
}(function ($) {
    var tmpl = $.summernote.renderer.getTemplate();
    var editor = $.summernote.eventHandler.getEditor();
    var emojis = ['arrow', 'confused', 'dizz', 'droll', 'ehh', 'gota', 'jeh'];

    if (!Array.prototype.chunk) {
        Array.prototype.chunk = function (chunkSize) {
            var R = [];
            for (var i = 0; i < this.length; i += chunkSize)
                R.push(this.slice(i, i + chunkSize));
            return R;
        }
    }

    /*IE polyfill*/
    if (!Array.prototype.filter) {
        Array.prototype.filter = function (fun /*, thisp*/) {
            var len = this.length >>> 0;
            if (typeof fun != "function")
                throw new TypeError();

            var res = [];
            var thisp = arguments[1];
            for (var i = 0; i < len; i++) {
                if (i in this) {
                    var val = this[i];
                    if (fun.call(thisp, val, i, this))
                        res.push(val);
                }
            }
            return res;
        };
    }

    var addListener = function () {
        $('body').on('click', '#emoji-filter', function (e) {
            e.stopPropagation();
            $('#emoji-filter').focus();
        });
        $('body').on('keyup', '#emoji-filter', function (e) {
            var filteredList = filterEmoji($('#emoji-filter').val());
            $("#emoji-dropdown .emoji-list").html(filteredList);
        });
    };

    var dropdown = function () {
        return '<div class="dropdown-menu dropdown-keep-open" id="emoji-dropdown" style="width: 200px; padding: 10px;">' +
            '<div class="row">' +
            '<div class="col-md-12">' +
            '<input type="text" class="form-control" id="emoji-filter"/>' +
            '<br/>' +
            '</div>' +
            '</div>' +
            '<div class="emoji-list">' +
            render(emojis) +
            '</div>' +
            '</div>';
    };

    var render = function (emojis) {
        var emoList = '';
        /*limit list to 24 images*/
        var emojis = emojis.slice(0, 24);
        var chunks = emojis.chunk(4);
        for (j = 0; j < chunks.length; j++) {
            emoList += '<div class="row">';
            for (var i = 0; i < chunks[j].length; i++) {
                var emo = chunks[j][i];
                emoList += '<div class="col-xs-3">' +
                '<a href="javascript:void(0)" data-event="selectEmoji" data-value=":' + emo + ':"><span style="background: url(\'' + document.emojiSource + emo + '.png\'); display: inline-block; width: 24px; height: 24px; background-size: 24px;"></span></a>' +
                '</div>';
            }
            emoList += '</div>';
        }

        return emoList;
    };

    var filterEmoji = function (value) {
        var filtered = emojis.filter(function (el) {
            return el.indexOf(value) > -1;
        });
        return render(filtered);
    };

    $.summernote.addPlugin({
        name: 'emoji',
        buttons: {
            emoji: function (options) {
                if(document.emojiSource === undefined)
					document.emojiSource = '';
                addListener();
                return tmpl.iconButton('fa fa-smile-o', {
                    title: 'Emoji',
                    hide: true,
                    dropdown: dropdown()
                });
            }
        },

        events: {
            selectEmoji: function (event, editor, layoutInfo, value) {
                var $editable = layoutInfo.editable();
                editor.insertText($editable, value);
            }
        }
    });
}));