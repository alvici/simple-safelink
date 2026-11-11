/* ==========================================================================
   Simple Safelink - app.js
   Countdown safelink, copy helpers, converter, nav
   ========================================================================== */
(function () {
  "use strict";

  /* Helpers ---------------------------------------------------------------- */
  function $(selector, scope) {
    return (scope || document).querySelector(selector);
  }

  function $all(selector, scope) {
    return Array.prototype.slice.call((scope || document).querySelectorAll(selector));
  }

  function hexDecode(hex) {
    var out = "";
    for (var i = 0; i < hex.length - 1; i += 2) {
      out += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
    }
    return out;
  }

  function showToast(message) {
    var toast = $("#toast");
    if (!toast) return;
    toast.textContent = message;
    toast.classList.add("is-visible");
    clearTimeout(showToast._timer);
    showToast._timer = setTimeout(function () {
      toast.classList.remove("is-visible");
    }, 1800);
  }

  function copyText(text) {
    if (navigator.clipboard && window.isSecureContext) {
      return navigator.clipboard.writeText(text);
    }
    return new Promise(function (resolve, reject) {
      var area = document.createElement("textarea");
      area.value = text;
      area.setAttribute("readonly", "");
      area.style.position = "fixed";
      area.style.opacity = "0";
      document.body.appendChild(area);
      area.select();
      try {
        document.execCommand("copy") ? resolve() : reject();
      } catch (err) {
        reject(err);
      }
      document.body.removeChild(area);
    });
  }

  /* Navigation ------------------------------------------------------------- */
  var nav = $("#siteNav");
  var navToggle = $("#navToggle");
  var navLinks = $("#navLinks");

  if (navToggle && navLinks) {
    navToggle.addEventListener("click", function () {
      navLinks.classList.toggle("is-open");
      navToggle.setAttribute("aria-expanded", navLinks.classList.contains("is-open"));
    });
  }

  if (nav) {
    var onScroll = function () {
      nav.classList.toggle("is-scrolled", window.scrollY > 8);
    };
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();
  }

  /* Countdown / safelink --------------------------------------------------- */
  var params = new URLSearchParams(window.location.search);
  var go = params.get("go");
  var target = "";
  var timer = $("#cDown");
  var visit = $("#visit");
  var startBtn = $("#startVisit");
  var finalBox = $("#visitFinal");
  var timer2 = $("#cDown2");
  var finalBar = $("#finalBar");
  var finalHint = $("#finalHint");
  var finalLink = $("#menuju");
  var finalStarted = false;
  var topReady = false;

  function startFinalCountdown() {
    if (finalStarted || !timer2) return;
    finalStarted = true;

    var total2 = parseInt(timer2.getAttribute("data-secs") || "5", 10);
    if (isNaN(total2) || total2 < 1) total2 = 5;

    var left2 = total2;
    timer2.textContent = left2;
    if (finalHint) finalHint.textContent = "Please wait, your link will unlock automatically.";

    var tick2 = setInterval(function () {
      left2 -= 1;
      if (left2 < 0) left2 = 0;
      timer2.textContent = left2;
      if (finalBar) finalBar.style.width = Math.min(100, ((total2 - left2) / total2) * 100) + "%";

      if (left2 <= 0) {
        clearInterval(tick2);
        timer2.textContent = "0";
        if (finalHint) finalHint.hidden = true;
        if (finalLink) {
          if (target) finalLink.setAttribute("href", target);
          finalLink.style.display = "inline-flex";
        }
      }
    }, 1000);
  }

  if (go && timer && visit) {
    try {
      target = decodeURIComponent(hexDecode(go));
    } catch (err) {
      target = "";
    }

    if (window.history && window.history.replaceState) {
      window.history.replaceState(null, "", window.location.pathname);
    }

    var total = parseInt(timer.getAttribute("data-secs") || timer.getAttribute("secs") || "5", 10);
    if (isNaN(total) || total < 1) total = 5;

    var left = total;
    var bar = $(".unlock__bar i", visit);
    var hint = $("#unlockHint");

    timer.textContent = left;

    var tick = setInterval(function () {
      left -= 1;
      if (left < 0) left = 0;
      timer.textContent = left;
      if (bar) bar.style.width = Math.min(100, ((total - left) / total) * 100) + "%";

      if (left <= 0) {
        clearInterval(tick);
        timer.textContent = "0";
        if (hint) hint.hidden = true;

        if (startBtn) {
          topReady = true;
          startBtn.hidden = false;
          startBtn.style.display = "inline-flex";

          if (finalBox && isFinalVisible()) {
            startFinalCountdown();
          }
        } else if (finalLink) {
          if (target) finalLink.setAttribute("href", target);
          finalLink.style.display = "inline-flex";
        }
      }
    }, 1000);
  }

  function scrollToFinal() {
    if (!finalBox) return;
    try {
      finalBox.scrollIntoView({ behavior: "smooth", block: "start" });
    } catch (err) {
      finalBox.scrollIntoView(true);
    }
  }

  function isFinalVisible() {
    if (!finalBox) return false;
    var rect = finalBox.getBoundingClientRect();
    return rect.top < window.innerHeight * 0.9 && rect.bottom > 0;
  }

  if (startBtn && finalBox) {
    startBtn.addEventListener("click", function () {
      scrollToFinal();
      startFinalCountdown();
    });
  }

  if (finalBox && timer2) {
    if ("IntersectionObserver" in window) {
      var finalObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting && topReady) {
            startFinalCountdown();
            finalObserver.disconnect();
          }
        });
      }, { threshold: 0.35 });

      finalObserver.observe(finalBox);
    } else {
      window.addEventListener("scroll", function () {
        if (!topReady) return;
        var rect = finalBox.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.8) startFinalCountdown();
      }, { passive: true });
    }
  }

  /* Copy buttons ----------------------------------------------------------- */
  document.addEventListener("click", function (event) {
    var button = event.target.closest("[data-copy]");
    if (!button) return;

    var value = button.getAttribute("data-copy");
    if (!value) {
      var input = button.parentElement.querySelector("input, textarea");
      value = input ? input.value : "";
    }
    if (!value) return;

    copyText(value)
      .then(function () {
        showToast("Link copied");
      })
      .catch(function () {
        showToast("Copy failed");
      });
  });

  /* Copy snippet ----------------------------------------------------------- */
  $all("[data-copy-snippet]").forEach(function (button) {
    button.addEventListener("click", function () {
      var box = button.closest(".snippet");
      var code = box ? $("code", box) : null;
      if (!code) return;
      copyText(code.textContent)
        .then(function () {
          showToast("Script copied");
        })
        .catch(function () {
          showToast("Copy failed");
        });
    });
  });

  /* Copy all results ------------------------------------------------------- */
  $all("[data-copy-all]").forEach(function (button) {
    button.addEventListener("click", function () {
      var box = button.closest(".results");
      var values = $all("input", box || document)
        .map(function (input) {
          return input.value;
        })
        .filter(Boolean);

      if (!values.length) return;
      copyText(values.join("\n"))
        .then(function () {
          showToast(values.length + " links copied");
        })
        .catch(function () {
          showToast("Copy failed");
        });
    });
  });

  /* Converter -------------------------------------------------------------- */
  var form = $("#convertForm");
  if (form) {
    var input = $("#linksInput");
    var results = $("#results");
    var list = $("#resultList");
    var submit = form.querySelector('button[type="submit"]');

    form.addEventListener("submit", function (event) {
      event.preventDefault();

      var text = (input.value || "").trim();
      if (!text) {
        showToast("Paste your links first");
        input.focus();
        return;
      }

      submit.disabled = true;
      submit.textContent = "Processing...";

      fetch(form.getAttribute("data-endpoint"), {
        method: "POST",
        headers: { "Content-Type": "text/plain;charset=UTF-8" },
        body: text
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (json) {
          list.innerHTML = "";
          (json.data || []).forEach(function (url) {
            var row = document.createElement("div");
            row.className = "result-row";

            var field = document.createElement("input");
            field.type = "text";
            field.value = url;
            field.readOnly = true;
            field.addEventListener("click", function () {
              field.select();
            });

            var copy = document.createElement("button");
            copy.type = "button";
            copy.className = "icon-btn";
            copy.setAttribute("data-copy", url);
            copy.setAttribute("aria-label", "Copy link");
            copy.innerHTML =
              '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>';

            row.appendChild(field);
            row.appendChild(copy);
            list.appendChild(row);
          });

          results.hidden = false;
          showToast((json.data || []).length + " links created");
        })
        .catch(function () {
          showToast("Failed to process links");
        })
        .finally(function () {
          submit.disabled = false;
          submit.textContent = "Convert Link";
        });
    });
  }

  /* Shortener -------------------------------------------------------------- */
  var shortForm = $("#shortForm");
  if (shortForm) {
    var shortInput = $("#shortInput");
    var shortResult = $("#shortResult");
    var shortList = $("#shortResultList");
    var shortSubmit = shortForm.querySelector('button[type="submit"]');

    shortForm.addEventListener("submit", function (event) {
      event.preventDefault();

      var text = (shortInput.value || "").trim();
      if (!text) {
        showToast("Paste your URLs first");
        shortInput.focus();
        return;
      }

      shortSubmit.disabled = true;
      shortSubmit.textContent = "Shortening...";

      fetch(shortForm.getAttribute("data-endpoint"), {
        method: "POST",
        headers: { "Content-Type": "text/plain;charset=UTF-8" },
        body: text
      })
        .then(function (response) {
          return response.json().then(function (json) {
            return { ok: response.ok, json: json };
          });
        })
        .then(function (result) {
          var json = result.json || {};

          if (!result.ok || !json.success) {
            showToast(json.message || "Failed to shorten URL");
            return;
          }

          var links = json.data || [];
          shortList.innerHTML = "";

          links.forEach(function (item) {
            var row = document.createElement("div");
            row.className = "result-row";

            var field = document.createElement("input");
            field.type = "text";
            field.value = item.short;
            field.readOnly = true;
            field.addEventListener("click", function () {
              field.select();
            });

            var copy = document.createElement("button");
            copy.type = "button";
            copy.className = "icon-btn";
            copy.setAttribute("data-copy", item.short);
            copy.setAttribute("aria-label", "Copy short link");
            copy.innerHTML =
              '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>';

            row.appendChild(field);
            row.appendChild(copy);
            shortList.appendChild(row);
          });

          shortResult.hidden = false;
          shortInput.value = "";

          var errors = json.errors || [];
          if (errors.length) {
            showToast(links.length + " shortened, " + errors.length + " skipped");
          } else {
            showToast(links.length + (links.length === 1 ? " short link created" : " short links created"));
          }
        })
        .catch(function () {
          showToast("Failed to shorten URL");
        })
        .finally(function () {
          shortSubmit.disabled = false;
          shortSubmit.textContent = "Shorten URL";
        });
    });
  }
})();
