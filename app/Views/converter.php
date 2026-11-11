<section class="section">
    <div class="container">
        <div class="converter-grid">
            <div class="card pad">
                <h2 class="card-title">Link Converter</h2>
                <p class="card-desc">Paste one link per line. Each link will be converted into a safelink with a countdown.</p>

                <form id="convertForm" data-endpoint="<?= base_url('convert'); ?>">
                    <div class="field">
                        <label for="linksInput">Links</label>
                        <textarea class="input" id="linksInput" name="links" rows="8" spellcheck="false"
                            placeholder="https://contoh.com/file-1.zip&#10;https://contoh.com/file-2.zip"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Convert Link</button>
                </form>

                <div class="results" id="results" hidden>
                    <div class="results-head">
                        <strong>Results</strong>
                        <button type="button" class="btn btn-ghost btn-sm" data-copy-all>Copy all</button>
                    </div>
                    <div id="resultList"></div>
                </div>
            </div>

            <div class="card pad">
                <h2 class="card-title">Shortener URL</h2>
                <p class="card-desc">Paste one link per line. Each link becomes a 7-character short link with no countdown.</p>

                <form id="shortForm" data-endpoint="<?= base_url('shorten'); ?>">
                    <div class="field">
                        <label for="shortInput">Long URLs</label>
                        <textarea class="input" id="shortInput" name="urls" rows="8" spellcheck="false"
                            placeholder="https://example.com/very/long/link-1&#10;https://example.com/very/long/link-2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Shorten URL</button>
                </form>

                <div class="results" id="shortResult" hidden>
                    <div class="results-head">
                        <strong>Your short links</strong>
                        <button type="button" class="btn btn-ghost btn-sm" data-copy-all>Copy all</button>
                    </div>
                    <div id="shortResultList"></div>
                </div>
            </div>
        </div>
    </div>
</section>
