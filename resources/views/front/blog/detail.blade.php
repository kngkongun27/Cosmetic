@extends('front.layout.master')

@section('title', 'Chi tiết bài viết')

@section('body')
<section id="blogDetail" class="py-5">
    <div class="container">
        <div v-if="blog" class="row">
            <!-- Nội dung chính -->
            <div class="col-lg-8">
                <h2 class="mb-3">@{{ blog.title }}</h2>
                <p class="text-muted mb-4">
                    <i class="fa fa-calendar me-2"></i>@{{ formatDate(blog.created_at) }}
                </p>

                <img v-if="blog.image && blog.image !== 'Null'" 
                     :src="'/storage/blog/' + blog.image" 
                     alt="@{{ blog.title }}" 
                     class="img-fluid rounded mb-4">
                <img v-else 
                     src="/storage/user/dfPost.jpg" 
                     alt="default" 
                     class="img-fluid rounded mb-4">

                <div v-html="blog.subtitle" class="blog-content"></div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 mt-5 mt-lg-0">
                <div class="card shadow-sm border-0">
                    <div class="card-header  text-white" style="background: rgb(15, 217, 177);">
                        <h5 class="mb-0">Bài viết liên quan</h5>
                    </div>
                    <div class="card-body">
                        <div v-for="item in related" :key="item.id" class="d-flex mb-3 align-items-center">
                            <a :href="'/chi-tiet-blog/' + item.slug" class="me-3">
                                <img :src="'/storage/blog/' + (item.image ?? 'dfPost.jpg')" 
                                     :alt="item.title"
                                     class="rounded" 
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            </a>
                            <div>
                                <a :href="'/chi-tiet-blog/' + item.slug" 
                                   class="text-dark fw-bold text-decoration-none">
                                    @{{ truncate(item.title, 50) }}
                                </a>
                                <p class="text-muted small mb-0">@{{ formatDate(item.created_at) }}</p>
                            </div>
                        </div>
                        <p v-if="!related.length" class="text-muted mb-0">Không có bài viết liên quan.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading -->
        <div v-else class="text-center py-5">
            <div class="spinner-border text-primary"></div>
            <p class="mt-3 text-muted">Đang tải bài viết...</p>
        </div>
    </div>
</section>

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>

<script>
const app = Vue.createApp({
    data() {
        return {
            blog: null,
            related: [],
        };
    },
    mounted() {
        const slug = window.location.pathname.split('/').pop();

        axios.get(`/getBlogDetail/${slug}`)
            .then(res => {
                this.blog = res.data.blog;
                this.related = res.data.related;
            })
            .catch(() => console.error("Không thể tải dữ liệu bài viết"));
    },
    methods: {
        formatDate(date) {
            return new Date(date).toLocaleDateString('vi-VN');
        },
        truncate(text, length) {
            return text?.length > length ? text.slice(0, length) + "..." : text;
        }
    }
});

app.mount("#blogDetail");
</script>
@endsection
