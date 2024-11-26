<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập Admin</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="./assets/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="./assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="./assets/dist/css/adminlte.min.css?v=3.2.0">
    <script nonce="69fc9b86-ecb6-4726-b6c0-dceab7234d3d">
        try {
            (function(w, d) {
                ! function(j, k, l, m) {
                    if (j.zaraz) console.error("zaraz is loaded twice");
                    else {
                        j[l] = j[l] || {};
                        j[l].executed = [];
                        j.zaraz = {
                            deferred: [],
                            listeners: []
                        };
                        j.zaraz._v = "5774";
                        j.zaraz.q = [];
                        j.zaraz._f = function(n) {
                            return async function() {
                                var o = Array.prototype.slice.call(arguments);
                                j.zaraz.q.push({
                                    m: n,
                                    a: o
                                })
                            }
                        };
                        for (const p of ["track", "set", "debug"]) j.zaraz[p] = j.zaraz._f(p);
                        j.zaraz.init = () => {
                            var q = k.getElementsByTagName(m)[0],
                                r = k.createElement(m),
                                s = k.getElementsByTagName("title")[0];
                            s && (j[l].t = k.getElementsByTagName("title")[0].text);
                            j[l].x = Math.random();
                            j[l].w = j.screen.width;
                            j[l].h = j.screen.height;
                            j[l].j = j.innerHeight;
                            j[l].e = j.innerWidth;
                            j[l].l = j.location.href;
                            j[l].r = k.referrer;
                            j[l].k = j.screen.colorDepth;
                            j[l].n = k.characterSet;
                            j[l].o = (new Date).getTimezoneOffset();
                            if (j.dataLayer)
                                for (const w of Object.entries(Object.entries(dataLayer).reduce(((x, y) => ({
                                        ...x[1],
                                        ...y[1]
                                    })), {}))) zaraz.set(w[0], w[1], {
                                    scope: "page"
                                });
                            j[l].q = [];
                            for (; j.zaraz.q.length;) {
                                const z = j.zaraz.q.shift();
                                j[l].q.push(z)
                            }
                            r.defer = !0;
                            for (const A of [localStorage, sessionStorage]) Object.keys(A || {}).filter((C => C.startsWith("_zaraz_"))).forEach((B => {
                                try {
                                    j[l]["z_" + B.slice(7)] = JSON.parse(A.getItem(B))
                                } catch {
                                    j[l]["z_" + B.slice(7)] = A.getItem(B)
                                }
                            }));
                            r.referrerPolicy = "origin";
                            r.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(j[l])));
                            q.parentNode.insertBefore(r, q)
                        };
                        ["complete", "interactive"].includes(k.readyState) ? zaraz.init() : j.addEventListener("DOMContentLoaded", zaraz.init)
                    }
                }(w, d, "zarazData", "script");
                window.zaraz._p = async eX => new Promise((eY => {
                    if (eX) {
                        eX.e && eX.e.forEach((eZ => {
                            try {
                                const e$ = d.querySelector("script[nonce]"),
                                    fa = e$?.nonce || e$?.getAttribute("nonce"),
                                    fb = d.createElement("script");
                                fa && (fb.nonce = fa);
                                fb.innerHTML = eZ;
                                fb.onload = () => {
                                    d.head.removeChild(fb)
                                };
                                d.head.appendChild(fb)
                            } catch (fc) {
                                console.error(`Error executing script: ${eZ}\n`, fc)
                            }
                        }));
                        Promise.allSettled((eX.f || []).map((fd => fetch(fd[0], fd[1]))))
                    }
                    eY()
                }));
                zaraz._p({
                    "e": ["(function(w,d){})(window,document)"]
                });
            })(window, document)
        } catch (e) {
            throw fetch("/cdn-cgi/zaraz/t"), e;
        };
    </script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="./assets/index2.html" class="h1">Bán Sách</a>
            </div>
            <div class="card-body">
            <?php if(isset($_SESSION['error'])) {?>
                    <p class="text-danger login-box-msg"><?= $_SESSION['error']?></p>
                  <?php } else { ?>
                    <?php ?>
                <p class="login-box-msg">Vui lòng đăng nhập</p>
                <?php } ?>
                <form action="<?= BASE_URL_ADMIN .'?act=check-login-admin' ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                 

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                        </div>

                    </div>
                </form>
           

                <p class="mb-1">
                    <a href="#">Quên mật khẩu</a>
                </p>
               
            </div>

        </div>

    </div>


    <script src="./assets/plugins/jquery/jquery.min.js"></script>

    <script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="./assets/dist/js/adminlte.min.js?v=3.2.0"></script>
</body>

</html>