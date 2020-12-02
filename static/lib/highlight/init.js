document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.corepress-code-pre code').forEach((block) => {
        hljs.highlightBlock(block);
    });

});
$('.corepress-code-pre').append('<div class="code-bar"><i class="fal fa-clone code-bar-btn-copy-fonticon" title="复制"></i></div>')
$(".corepress-code-pre code").each(function () {
    $(this).html("<ul class='hijs-line-number'><li>" + $(this).html().replace(/\n/g, "\n</li><li>") + "\n</li></ul>");
});
