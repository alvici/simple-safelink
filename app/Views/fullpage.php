<section class="section">
    <div class="container">
        <div class="script-intro">
            <h2 class="card-title">Auto Safelink Script</h2>
            <p class="card-desc">Copy the script below into your page. Every link will automatically be converted into a safelink without editing each one manually.</p>
        </div>

        <div class="script-grid">
            <div class="card pad">
                <div class="snippet">
                    <div class="snippet-head">
                        <strong>Selected domains only</strong>
                        <button type="button" class="btn btn-ghost btn-sm" data-copy-snippet>Copy</button>
                    </div>
                    <pre><code>&lt;script type="text/javascript"&gt;
var apphost = '<?= base_domain(); ?>';
var shorts = ['mega.nz', 'mediafire.com', 'drive.google.com', 'pixeldrain.com', 'gofile.io'];
&lt;/script&gt;
&lt;script type="text/javascript" src="<?= asset('js/link-converter.js'); ?>"&gt;&lt;/script&gt;</code></pre>
                </div>
            </div>

            <div class="card pad">
                <div class="snippet">
                    <div class="snippet-head">
                        <strong>All links except selected domains</strong>
                        <button type="button" class="btn btn-ghost btn-sm" data-copy-snippet>Copy</button>
                    </div>
                    <pre><code>&lt;script type="text/javascript"&gt;
var apphost = '<?= base_domain(); ?>';
var exclude_domains = ['facebook.com', 'x.com', 'instagram.com', 'tiktok.com', 'youtube.com'];
&lt;/script&gt;
&lt;script type="text/javascript" src="<?= asset('js/link-converter.js'); ?>"&gt;&lt;/script&gt;</code></pre>
                </div>
            </div>
        </div>

        <div class="note">
            <span aria-hidden="true">&#9432;</span>
            <span>Use only one of them. The first script converts only the domains you list, while the second converts every link except the excluded domains.</span>
        </div>
    </div>
</section>
