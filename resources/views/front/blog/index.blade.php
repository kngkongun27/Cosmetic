@extends('front.layout.master')

@section('title', 'Blog')



@section('body')

<section id="takeBlog" class="latest-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Về mỹ phẩm</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6" v-for="blog in listBlog">
                <div class="single-latest-blog">
                    <img :src="'/storage/blog/' + blog.image" alt="">
                    <div class="latest-text">
                        <div class="tag-list">
                            <div class="tag-item">
                                <i class="fa fa-calendar-o"></i>
                                @{{blog.created_at}}
                            </div>
                            <div class="tag-item">
                                <i class="fa fa-comment-o"></i>

                            </div>
                        </div>
                        <a :href="'/chi-tiet-blog/'+blog.slug">
                            <h4>@{{blog.title}}</h4>
                        </a>
                        <p>@{{blog.subtitle}} </p>
                    </div>
                </div>
            </div>

        </div>
        <div class="benefit-items">
            <div class="row">
                <div class="col-lg-4">
                    <div class="single-benefit">
                        <div class="sb-icon">
                            <img src="/front/img/icon-1.png" alt="">
                        </div>
                        <div class="sb-text">
                            <h6>Giao Hàng Nhanh Chóng</h6>
                            <p>Áp dụng cho mọi đơn hàng</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-benefit">
                        <div class="sb-icon">
                            <img src="/front/img/icon-2.png" alt="">
                        </div>
                        <div class="sb-text">
                            <h6>Đúng thời gian giao hàng</h6>
                            <p>Thời gian giao hàng chính xác</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-benefit">
                        <div class="sb-icon">
                            <img src="/front/img/icon-3.png" alt="">
                        </div>
                        <div class="sb-text">
                            <h6>Cam kết khi giao hàng</h6>
                            <p>Thanh toán khi nhận hàng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>




<script>
    const app = Vue.createApp({
        data() {
            return {
                listBlog: [],



            };
        }
        , mounted() {
            axios.get('/getBlog')
                .then(response => {
                    this.listBlog = response.data;
                    console.log(this.listBlog);
                })
        }
        , methods: {


        }
        , computed: {



        }
    , });

    const vueInstace = app.mount("#takeBlog");

</script>

@endsection
