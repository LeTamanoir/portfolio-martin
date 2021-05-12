var md = window.markdownit({
    html: true,
    linkify: true,
    typographer: true,
    breaks: true, 
    highlight: function (str, lang) { return '<pre class="hljs"><code>' + hljs.highlight(lang, str).value + '</code></pre>'; }
}).use(window.markdownitEmoji);