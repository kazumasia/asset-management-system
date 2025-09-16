<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="<?= base_url(); ?>/css/landing.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="cursor"></div>
    <div class="cursor-border"></div>
    <header>
        <a href="#home" class="logo"><img width="250" src="<?= base_url(); ?>img/bps.png" />
            Badan Pusat Statistik Kabupaten Ogan Ilir</a>
        <nav class="site-nav">
            <ul class="underline-menu">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#speakers">Speakers</a></li>
                <li><a href="#schedule">Schedule</a></li>
                <li><a href="#location">Location</a></li>
                <li><a href="#sponsors">Sponsors</a></li>
            </ul>
        </nav>
    </header>
    <input type="checkbox" id="burger-toggle" />
    <label for="burger-toggle" class="burger-menu">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </label>
    <div class="overlay"></div>
    <nav class="burger-nav">
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#speakers">Speakers</a></li>
            <li><a href="#schedule">Schedule</a></li>
            <li><a href="#location">Location</a></li>
            <li><a href="#sponsors">Sponsors</a></li>
        </ul>
    </nav>
    <main>
        <section class="hero-section" id="home">
            <h1>
                Selamat Datang <br>Di Badan Pusat Statistik Kabupaten Ogan Ilir
            </h1>
            <h2>Silahkan isi Buku Tamu</h2>
            <a class="btn btn-ghost btn-through" href="https://www.yuque.com/cssconf/5th" target="_blank">
                Buku Tamu <span> </a>
        </section>
        <section class="normal-section" id="about">
            <div class="titles">
                <h1 class="cross-bar-glitch" data-slice="20">ABOUT</h1>
                <h2 class="staggered-rise-in">大会简介</h2>
            </div>
            <div class="description">
                <p class="fade-up">
                    中国第五届CSS开发者大会于2019年03月30日在深圳举办。由W3C、w3ctech、前端圈主办。本次大会我们将邀请行业内知名讲师，与大家共聚深圳，畅聊CSS。
                </p>
                <p class="fade-up">
                    CSS布局经常是令前端开发者头痛的一块工作。但是近几年来，浏览器不断发展，开始支持弹性盒子、网格布局、盒模型对齐等布局功能。这些CSS标准纯粹是为了应付网络布局而编写的。我们将深入了解这些新属性的特征，新时代的布局技巧、例子及最佳实践。希望听众会有所启发，利用这些新的CSS属性创造更符合浏览器本质的设计。
                </p>
                <p class="fade-up">
                    虽然在 CSS
                    里不能直观地绘制出一条曲线，或者动态生成许多元素，我们仍然可以利用 CSS
                    属性自身的特性，结合一些基本方法和想象力生成出非常有趣的图形，进行艺术创作。此次演讲就把这些过程和所使用的方法分享给大家。
                </p>
                <p class="fade-up">
                    CSS的有趣之处就在于最终呈现出来的技能强弱与你自身的思维方式，创造力是密切相关的，本次分享通过一些精彩的案例，展现创意如何让CSS的视觉表现变得更有趣的。
                </p>
            </div>
        </section>
        <section class="normal-section" id="speakers">
            <div class="titles">
                <h1 class="cross-bar-glitch" data-slice="20">SPEAKERS</h1>
                <h2 class="staggered-rise-in">演讲嘉宾</h2>
            </div>
            <div class="speakers-cards">
                <div class="card">
                    <div class="card-borders">
                        <div class="border-top"></div>
                        <div class="border-right"></div>
                        <div class="border-bottom"></div>
                        <div class="border-left"></div>
                    </div>
                    <div class="card-content">
                        <img src="https://img.w3ctech.com/cssconf5-brian.jpg" class="avatar" />
                        <div class="username">Brian Birtles</div>
                        <div class="info">火狐浏览器工程师<br />W3C CSS工作组成员</div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-borders">
                        <div class="border-top"></div>
                        <div class="border-right"></div>
                        <div class="border-bottom"></div>
                        <div class="border-left"></div>
                    </div>
                    <div class="card-content">
                        <img src="https://img.w3ctech.com/hjchen.jpg" class="avatar" />
                        <div class="username">陈慧晶</div>
                        <div class="info">知名CSS专家<br />Nexmo开发大使</div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-borders">
                        <div class="border-top"></div>
                        <div class="border-right"></div>
                        <div class="border-bottom"></div>
                        <div class="border-left"></div>
                    </div>
                    <div class="card-content">
                        <img src="https://img.w3ctech.com/cssconf5-zaizhen.jpg" class="avatar" />
                        <div class="username">陈在真</div>
                        <div class="info">腾讯CDC高级前端开发</div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-borders">
                        <div class="border-top"></div>
                        <div class="border-right"></div>
                        <div class="border-bottom"></div>
                        <div class="border-left"></div>
                    </div>
                    <div class="card-content">
                        <img src="https://img.w3ctech.com/damo.jpg" class="avatar" />
                        <div class="username">大漠</div>
                        <div class="info">知名CSS专家<br />阿里巴巴前端技术专家</div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-borders">
                        <div class="border-top"></div>
                        <div class="border-right"></div>
                        <div class="border-bottom"></div>
                        <div class="border-left"></div>
                    </div>
                    <div class="card-content">
                        <img src="https://img.w3ctech.com/gougu.jpg" class="avatar" />
                        <div class="username">勾三股四</div>
                        <div class="info">阿里巴巴高级前端技术专家</div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-borders">
                        <div class="border-top"></div>
                        <div class="border-right"></div>
                        <div class="border-bottom"></div>
                        <div class="border-left"></div>
                    </div>
                    <div class="card-content">
                        <img src="https://img.w3ctech.com/cssconf5-yuanchuan.jpg" class="avatar" />
                        <div class="username">袁川</div>
                        <div class="info">资深前端工程师<br />css-doodle 作者</div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-borders">
                        <div class="border-top"></div>
                        <div class="border-right"></div>
                        <div class="border-bottom"></div>
                        <div class="border-left"></div>
                    </div>
                    <div class="card-content">
                        <img src="https://img.w3ctech.com/zhangxx@2x.jpg" class="avatar" />
                        <div class="username">张鑫旭</div>
                        <div class="info">
                            知名CSS专家<br />《CSS世界》作者<br />阅文集团前端开发
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="normal-section" id="schedule">
            <div class="titles">
                <h1 class="cross-bar-glitch" data-slice="20">SCHEDULE</h1>
                <h2 class="staggered-rise-in">日程安排</h2>
            </div>
            <ul class="timeline">
                <li class="timeline__line"></li>
                <li class="timeline__item start">
                    <div class="info">
                        <div class="dot"></div>
                        <time class="time">08:30</time>
                        <h4 class="title">签到</h4>
                    </div>
                </li>
                <li class="timeline__item">
                    <div class="info">
                        <div class="dot"></div>
                        <time class="time">09:30</time>
                        <h4 class="speaker">陈慧晶</h4>
                        <h4 class="title">
                            <a target="_blank" href="https://www.yuque.com/cssconf/yog9rr/hmzpxe">新时代CSS布局
                            </a>
                        </h4>
                    </div>
                    <div class="content">
                        ​CSS布局经常是令前端开发者头痛的一块工作。但是近几年来，浏览器不断发展，开始支持弹性盒子、网格布局、盒模型对齐等布局功能。这些CSS标准纯粹是为了应付网络布局而编写的。我们将深入了解这些新属性的特征，新时代的布局技巧、例子及最佳实践。希望听众会有所启发，利用这些新的CSS属性创造更符合浏览器本质的设计。
                    </div>
                </li>
                <li class="timeline__item">
                    <div class="info">
                        <div class="dot"></div>
                        <time class="time">10:20</time>
                        <h4 class="speaker">大漠</h4>
                        <h4 class="title">
                            <a target="_blank"
                                href="https://www.yuque.com/cssconf/yog9rr/no7l1o">剖析css-tricks新版，为你所用</a>
                        </h4>
                    </div>
                    <div class="content">
                        新版css-tricks.com网站在社交媒体上得到众多好评，今天我们就一起来聊聊这次改版中运用到的一些新特性，这些新特性对用户体验带来什么样的改变，我们又如何将这些新特性运用于自己的项目中。
                    </div>
                </li>
                <li class="timeline__item break">
                    <div class="info">
                        <div class="dot"></div>
                        <time class="time">12:00</time>
                        <h4 class="title">午餐</h4>
                    </div>
                </li>
                <li class="timeline__item">
                    <div class="info">
                        <div class="dot"></div>
                        <time class="time">13:00</time>
                        <h4 class="speaker">张鑫旭</h4>
                        <h4 class="title">
                            <a target="_blank" href="https://www.yuque.com/cssconf/yog9rr/rpl1tf">CSS创意与视觉表现</a>
                        </h4>
                    </div>
                    <div class="content">
                        CSS的有趣之处就在于最终呈现出来的技能强弱与你自身的思维方式，创造力是密切相关的，本次分享通过一些精彩的案例，展现创意如何让CSS的视觉表现变得更有趣的。
                    </div>
                </li>
                <li class="timeline__item">
                    <div class="info">
                        <div class="dot"></div>
                        <time class="time">14:00</time>
                        <h4 class="speaker">袁川</h4>
                        <h4 class="title">
                            <a target="_blank" href="https://www.yuque.com/cssconf/yog9rr/hyku3f">CSS生成艺术</a>
                        </h4>
                    </div>
                    <div class="content">
                        虽然在 CSS
                        里不能直观地绘制出一条曲线，或者动态生成许多元素，我们仍然可以利用 CSS
                        属性自身的特性，结合一些基本方法和想象力生成出非常有趣的图形，进行艺术创作。此次演讲就把这些过程和所使用的方法分享给大家。
                    </div>
                </li>
                <li class="timeline__item">
                    <div class="info">
                        <div class="dot"></div>
                        <time class="time">14:50</time>
                        <h4 class="speaker">勾三股四</h4>
                        <h4 class="title">
                            <a target="_blank" href="https://www.yuque.com/cssconf/yog9rr/vg70mz">你不知道的五个 CSS 新特性</a>
                        </h4>
                    </div>
                    <div class="content">
                        分享五个讲者在近期学习标准的过程中，发现的鲜为人知的 CSS
                        特性，并通过相关代码、示例和故事，帮助大家发掘 CSS
                        更多的乐趣和用武之地。
                    </div>
                </li>
                <li class="timeline__item break">
                    <div class="info">
                        <div class="dot"></div>
                        <time class="time">15:40</time>
                        <h4 class="title">Coffee Time</h4>
                    </div>
                </li>
                <li class="timeline__item">
                    <div class="info">
                        <div class="dot"></div>
                        <time class="time">16:20</time>
                        <h4 class="speaker">Brian Birtles</h4>
                        <h4 class="title">
                            <a target="_blank" href="https://www.yuque.com/cssconf/yog9rr/nays55">10 things I wish CSS
                                authors knew about animations</a>
                        </h4>
                    </div>
                    <div class="content">
                        动画可以让你的网站或 app
                        更加自然、有趣、优美，但动画本身也可能是困难、缓慢、使人不悦的。让我们来一起看看一些浏览器发行者们希望作者们知道的，关于动画常见的误解、不为人知的特性、以及即将到来的技术。
                    </div>
                </li>
                <li class="timeline__item">
                    <div class="info">
                        <div class="dot"></div>
                        <time class="time">17:30</time>
                        <h4 class="speaker">陈在真</h4>
                        <h4 class="title">
                            <a target="_blank" href="https://www.yuque.com/cssconf/yog9rr/hbix70">CSS TIME</a>
                        </h4>
                    </div>
                    <div class="content">
                        时间概念对于动画而言犹如灵魂一般，在WEB
                        CSS中同样存在着时间范畴，Duration? Delay?
                        究竟CSS的时间概念存在于哪些地方，又能起到哪些作用？我们将基于Demo实例由浅入深逐一分析CSS
                        TIME，也许从此你对它会有新的认知。
                    </div>
                </li>
                <li class="timeline__item end">
                    <div class="info">
                        <div class="dot"></div>
                        <time class="time">18:30</time>
                        <h4 class="title">结束</h4>
                    </div>
                </li>
            </ul>
        </section>
        <section class="normal-section" id="location">
            <div class="titles">
                <h1 class="cross-bar-glitch" data-slice="20">LOCATION</h1>
                <h2 class="staggered-rise-in">举办地点</h2>
            </div>
            <div class="place">
                <div class="marker fade-in">
                    <div class="pin"></div>
                    <div class="shadow"></div>
                </div>
                <div class="place-name cross-bar-glitch" data-slice="20">
                    深圳 科兴科学园
                </div>
            </div>
            <div id="map" class="fade-in"></div>
        </section>
        <section class="normal-section" id="sponsors">
            <div class="titles">
                <h1 class="cross-bar-glitch" data-slice="20">SPONSORS</h1>
                <h2 class="staggered-rise-in">赞助商</h2>
            </div>
            <ul class="sponsors-list">
                <li class="fade-up">
                    <a href="http://www.ucloud.cn" target="_blank">
                        <img src="https://img.w3ctech.com/ucloud-400.png" alt="Ucloud" />
                    </a>
                    <div>赞助商</div>
                </li>
                <li class="fade-up">
                    <a href="http://www.broadview.com.cn/" target="_blank">
                        <img src="https://img.w3ctech.com/bowen.png" alt="博文视点" />
                    </a>
                    <div>赞助商</div>
                </li>
                <li class="fade-up">
                    <a href="http://www.ituring.com.cn/" target="_blank">
                        <img src="https://img.w3ctech.com/turing-logo.png" alt="图灵教育" />
                    </a>
                    <div>赞助商</div>
                </li>
                <li class="fade-up">
                    <a href="http://www.epubit.com.cn/" target="_blank">
                        <img src="https://img.w3ctech.com/yibuclub.png" alt="异步社区" />
                    </a>
                    <div>赞助商</div>
                </li>
                <li class="fade-up">
                    <a href="http://www.w3cplus.com/" target="_blank">
                        <img src="https://img.w3ctech.com/w3c-plus-400.png" alt="w3cplus" />
                    </a>
                    <div>支持社区</div>
                </li>
                <li class="fade-up">
                    <a href=" https://zdk.f2er.net/" target="_blank">
                        <img src="https://img.w3ctech.com/zdk_400.png" alt="前端de早读课" />
                    </a>
                    <div>支持社区</div>
                </li>
                <li class="fade-up">
                    <a href="http://gold.xitu.io/" target="_blank">
                        <img src="https://img.w3ctech.com/juejin-logo.png" alt="稀土掘金" />
                    </a>
                    <div>支持社区</div>
                </li>
                <li class="fade-up">
                    <a href="http://qianduan.guru/" target="_blank"><img
                            src="https://img.w3ctech.com/frontendmagezine.png" alt="前端外刊评论" /></a>
                    <div>支持社区</div>
                </li>
                <li class="fade-up">
                    <a href="https://www.oschina.net/" target="_blank"><img src="https://img.w3ctech.com/oschina.png"
                            alt="开源中国" /></a>
                    <div>支持社区</div>
                </li>
                <li class="fade-up">
                    <a href="https://www.uisdc.com/" target="_blank"><img src="https://img.w3ctech.com/uisdc.png"
                            alt="优设" /></a>
                    <div>支持社区</div>
                </li>
            </ul>
        </section>
    </main>

</body>
<script src="<?= base_url(); ?>/js/landing.js"></script>

</html>