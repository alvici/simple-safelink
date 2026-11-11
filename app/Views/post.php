<?php $hasGo = (bool) $this->get('go'); ?>

<section class="section">
    <div class="container">
        <div class="post-wrap">

            <?php if ($hasGo): ?>
            <div class="unlock" id="visit">
                <div class="unlock__label">Preparing your link</div>
                <div class="unlock__timer">
                    <span id="cDown" data-secs="<?= (int) config('countdown'); ?>"><?= (int) config('countdown'); ?></span>
                    <small>seconds</small>
                </div>
                <div class="unlock__bar" aria-hidden="true"><i></i></div>
                <button type="button" class="btn btn-primary" id="startVisit" style="display:none;">
                    Click Here
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 5v14M19 12l-7 7-7-7" />
                    </svg>
                </button>
                <p class="unlock__hint" id="unlockHint">Please wait, the button will appear shortly.</p>
            </div>
            <?php endif; ?>

            <div class="card article-card">
                <div class="prose">
                    <?php readfile($post_content); ?>
                </div>
            </div>

            <?php if ($hasGo): ?>
            <div class="unlock unlock--final" id="visitFinal">
                <div class="unlock__label">Final step</div>
                <div class="unlock__timer">
                    <span id="cDown2" data-secs="<?= (int) config('countdown'); ?>"><?= (int) config('countdown'); ?></span>
                    <small>seconds</small>
                </div>
                <div class="unlock__bar" aria-hidden="true"><i id="finalBar"></i></div>
                <a href="#" class="btn btn-success" id="menuju" style="display:none;">
                    Open Link
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M7 17 17 7M8 7h9v9" />
                    </svg>
                </a>
                <p class="unlock__hint" id="finalHint">Click "Click Here" above to start the final countdown.</p>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>
