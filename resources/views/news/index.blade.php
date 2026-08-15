@extends('layouts.frontend')

@section('title', 'Berita - Apotek Medistra Farma')

@section('styles')
    <style>
        body {
            background: #050505 !important;
            overflow: hidden !important;
        }

        .news-item.is-selected {
            box-shadow: 0 0 0 2px rgba(251, 191, 36, 0.9), 0 18px 40px rgba(0,0,0,0.42) !important;
        }

        .navbar,
        .footer,
        .float-wrap,
        .page-offset > .container,
        .page-offset > .alert {
            display: none !important;
        }

        main.page-offset {
            margin: 0 !important;
            padding: 0 !important;
            min-height: 100vh !important;
            background: #050505 !important;
        }
    </style>
@endsection

@section('content')
<style>
    @media (max-width: 768px) {
        #prevNewsBtn, #nextNewsBtn {
            display: none !important;
        }
    }
</style>
<section style="background:#050505; min-height:100vh; padding:0; margin:0; overflow:hidden; position:relative;">
    @if($news->count() > 0)
        <button id="prevNewsBtn" type="button" aria-label="Konten sebelumnya" style="position:fixed; right:10px; top:calc(50% - 48px); z-index:50; width:38px; height:38px; border-radius:50%; border:1px solid rgba(255,255,255,0.12); background:rgba(255,255,255,0.14); color:#fff; font-size:1.1rem; display:flex; align-items:center; justify-content:center; box-shadow:0 10px 20px rgba(0,0,0,0.28); cursor:pointer; pointer-events:auto; transition:all 0.2s ease;" onclick="window.newsNavigate('prev')" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.14)'">
            ↑
        </button>
        <button id="nextNewsBtn" type="button" aria-label="Konten berikutnya" style="position:fixed; right:10px; top:calc(50% + 10px); z-index:50; width:38px; height:38px; border-radius:50%; border:1px solid rgba(255,255,255,0.12); background:rgba(255,255,255,0.14); color:#fff; font-size:1.1rem; display:flex; align-items:center; justify-content:center; box-shadow:0 10px 20px rgba(0,0,0,0.28); cursor:pointer; pointer-events:auto; transition:all 0.2s ease;" onclick="window.newsNavigate('next')" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.14)'">
            ↓
        </button>
    @endif
    <div style="width:100%; height:100vh; display:flex; justify-content:center; align-items:center; background:#050505;">
        @if($news->count() > 0)
            <div id="newsFeed" style="width:100%; max-width:480px; height:100vh; overflow-y:auto; scroll-snap-type:y mandatory; scroll-behavior:smooth; scrollbar-width:none; -ms-overflow-style:none; background:#050505; padding-top:0.25rem; position:relative;">
                @foreach($news as $item)
                    @php
                        $galleryImages = is_array($item->gallery) ? $item->gallery : [];
                        $displayMedia = $galleryImages ?: [$item->file];
                    @endphp

                    <div class="news-item" data-news-id="{{ $item->id }}" style="position:relative; width:100%; min-height:calc(100vh - 0.5rem); scroll-snap-align:start; scroll-snap-stop:always; display:flex; align-items:center; justify-content:center; padding:0 0.2rem 0.35rem; box-sizing:border-box;">
                        <div style="position:relative; width:100%; max-width:410px; height:92vh; min-height:600px; border-radius:1.15rem; overflow:hidden; background:#0f172a; box-shadow:0 10px 28px rgba(0,0,0,0.38); border:1px solid rgba(255,255,255,0.08);">
                            @if(!empty($displayMedia))
                                @if(count($displayMedia) > 1)
                                    <div class="galleryScroll" style="display:flex; width:100%; height:100%; overflow-x:auto; scroll-snap-type:x mandatory; scroll-behavior:smooth; scrollbar-width:none;">
                                        @foreach($displayMedia as $galleryItem)
                                            @if($galleryItem && is_string($galleryItem))
                                                <div class="gallery-item" style="min-width:100%; height:100%; scroll-snap-align:start; position:relative;">
                                                    @if(str_contains(strtolower($galleryItem), '.mp4') || str_contains(strtolower($galleryItem), '.webm') || str_contains(strtolower($galleryItem), '.mov'))
                                                        <div style="position: relative; width: 100%; height: 100%;">
                                                            <video class="media-video" playsinline style="display:block; width:100%; height:100%; object-fit:contain; background:#dfeaf2; cursor: pointer;">
                                                                @php
                                                                    $ext = strtolower(pathinfo($galleryItem, PATHINFO_EXTENSION));
                                                                    $mimeType = match($ext) {
                                                                        'webm' => 'video/webm',
                                                                        'mov' => 'video/quicktime',
                                                                        default => 'video/mp4'
                                                                    };
                                                                @endphp
                                                                <source src="{{ asset('storage/' . $galleryItem) }}" type="{{ $mimeType }}">
                                                                Browser Anda tidak mendukung video.
                                                            </video>
                                                            <div class="volume-control" style="position: absolute; right: 0.8rem; bottom: 0.9rem; display: flex; align-items: center; gap: 0.45rem; z-index: 6; pointer-events: auto; background: rgba(0,0,0,0.25); padding: 0.45rem 0.6rem; border-radius: 999px; backdrop-filter: blur(6px);">
                                                                <input type="range" class="volume-slider" min="0" max="100" value="70" style="width: 58px; height: 4px; accent-color: #fbbf24; cursor: pointer; transform: rotate(0deg);">
                                                                <div class="volume-icon" style="font-size: 1rem; color: #fbbf24; text-shadow: 0 1px 3px rgba(0,0,0,0.7); width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">🔊</div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img src="{{ asset('storage/' . $galleryItem) }}" alt="{{ $item->judul }}" style="display:block; width:100%; height:100%; object-fit:contain; object-position:center; background:#dfeaf2; padding:0.35rem;">
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <button type="button" class="galleryPrev" aria-label="Foto sebelumnya" style="position:absolute; left:0.8rem; top:50%; transform:translateY(-50%); z-index:12; width:32px; height:32px; border:none; border-radius:50%; background:rgba(15,23,42,0.65); color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.1rem; box-shadow:0 6px 18px rgba(0,0,0,0.25); cursor:pointer;">
                                        ‹
                                    </button>
                                    <button type="button" class="galleryNext" aria-label="Foto berikutnya" style="position:absolute; right:0.8rem; top:50%; transform:translateY(-50%); z-index:12; width:32px; height:32px; border:none; border-radius:50%; background:rgba(15,23,42,0.65); color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.1rem; box-shadow:0 6px 18px rgba(0,0,0,0.25); cursor:pointer;">
                                        ›
                                    </button>

                                    <div style="position:absolute; top:0.9rem; right:0.9rem; z-index:11; background:rgba(15,23,42,0.75); color:#fff; font-size:0.72rem; border-radius:999px; padding:0.35rem 0.7rem; font-weight:700; border:1px solid rgba(255,255,255,0.18);">
                                        <span class="currentSlide">1</span>/{{ count($displayMedia) }}
                                    </div>
                                @else
                                    @php $singleMedia = $displayMedia[0]; @endphp
                                    @if(str_contains(strtolower($singleMedia), '.mp4') || str_contains(strtolower($singleMedia), '.webm') || str_contains(strtolower($singleMedia), '.mov'))
                                        <div style="position: relative; width: 100%; height: 100%;">
                                            <video class="media-video" playsinline style="display:block; width:100%; height:100%; object-fit:contain; background:#dfeaf2; cursor: pointer;">
                                                @php
                                                    $ext = strtolower(pathinfo($singleMedia, PATHINFO_EXTENSION));
                                                    $mimeType = match($ext) {
                                                        'webm' => 'video/webm',
                                                        'mov' => 'video/quicktime',
                                                        default => 'video/mp4'
                                                    };
                                                @endphp
                                                <source src="{{ asset('storage/' . $singleMedia) }}" type="{{ $mimeType }}">
                                                Browser Anda tidak mendukung video.
                                            </video>
                                            <div class="volume-control" style="position: absolute; right: 0.8rem; bottom: 0.9rem; display: flex; align-items: center; gap: 0.45rem; z-index: 6; pointer-events: auto; background: rgba(0,0,0,0.25); padding: 0.45rem 0.6rem; border-radius: 999px; backdrop-filter: blur(6px);">
                                                <input type="range" class="volume-slider" min="0" max="100" value="70" style="width: 58px; height: 4px; accent-color: #fbbf24; cursor: pointer; transform: rotate(0deg);">
                                                <div class="volume-icon" style="font-size: 1rem; color: #fbbf24; text-shadow: 0 1px 3px rgba(0,0,0,0.7); width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">🔊</div>
                                            </div>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/' . $singleMedia) }}" alt="{{ $item->judul }}" style="display:block; width:100%; height:100%; object-fit:contain; object-position:center; background:#dfeaf2; padding:0.35rem;">
                                    @endif
                                @endif
                            @endif

                            <div style="position:absolute; inset:0; background:linear-gradient(180deg, rgba(0,0,0,0.12) 0%, rgba(0,0,0,0.06) 35%, rgba(0,0,0,0.10) 62%, rgba(0,0,0,0.82) 100%); z-index:2; pointer-events:none;"></div>

                            <div style="position:absolute; right:1rem; bottom:7.5rem; z-index:10; display:flex; flex-direction:column; align-items:center; gap:1rem;">
                                <!-- Like Button -->
                                <div style="display:flex; flex-direction:column; align-items:center; gap:0.25rem;">
                                    <button class="likeBtn" style="width:44px; height:44px; border:none; border-radius:50%; background:linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%); color:#ff6b6b; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:1.3rem; backdrop-filter:blur(8px); box-shadow:0 8px 24px rgba(0,0,0,0.3); transition:all 0.2s ease; border:1px solid rgba(255,255,255,0.1);" onmouseover="this.style.background='linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.12) 100%)'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%)'; this.style.transform='scale(1)'">
                                        <span class="likeIcon">❤</span>
                                    </button>
                                    <div class="likeCount" style="color:#fff; font-size:0.7rem; font-weight:700; min-height:0.75rem; line-height:0.75rem; text-align:center;">{{ $item->like_count > 0 ? $item->like_count : '' }}</div>
                                </div>

                                <!-- Comment Button -->
                                <div style="display:flex; flex-direction:column; align-items:center; gap:0.25rem;">
                                    <button class="commentBtn" style="width:44px; height:44px; border:none; border-radius:50%; background:linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%); color:#00d4ff; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:1.3rem; backdrop-filter:blur(8px); box-shadow:0 8px 24px rgba(0,0,0,0.3); transition:all 0.2s ease; border:1px solid rgba(255,255,255,0.1);" onmouseover="this.style.background='linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.12) 100%)'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%)'; this.style.transform='scale(1)'">
                                        💬
                                    </button>
                                    <div class="commentCount" style="color:#fff; font-size:0.7rem; font-weight:700; min-height:0.75rem; line-height:0.75rem; text-align:center;">{{ $item->comment_count > 0 ? $item->comment_count : '' }}</div>
                                </div>

                                <!-- Share Button -->
                                <div style="display:flex; flex-direction:column; align-items:center; gap:0.25rem;">
                                    <button class="shareBtn" style="width:44px; height:44px; border:none; border-radius:50%; background:linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%); color:#fbbf24; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:1.25rem; backdrop-filter:blur(8px); box-shadow:0 8px 24px rgba(0,0,0,0.3); transition:all 0.2s ease; border:1px solid rgba(255,255,255,0.1);" onmouseover="this.style.background='linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.12) 100%)'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%)'; this.style.transform='scale(1)'">
                                        🔗
                                    </button>
                                    <div class="shareCount" style="color:#fff; font-size:0.7rem; font-weight:700; min-height:0.75rem; line-height:0.75rem; text-align:center;">{{ $item->share_count > 0 ? $item->share_count : '' }}</div>
                                </div>
                            </div>

                            <div style="position:absolute; left:1rem; right:6rem; bottom:0.8rem; z-index:7;">
                                <div class="newsDescription" data-news-id="{{ $item->id }}" style="font-size:0.85rem; line-height:1.4; color:#e2e8f0; margin:0 0 0.45rem; word-break:break-word; max-height:3.4em; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;">{{ $item->deskripsi }}</div>
                                @php $descLength = strlen($item->deskripsi); @endphp
                                @if($descLength > 150)
                                    <button class="readMoreBtn" data-news-id="{{ $item->id }}" data-description="{{ $item->deskripsi }}" style="background:none; border:none; color:#fbbf24; font-weight:600; font-size:0.7rem; padding:0.2rem 0 0; cursor:pointer; text-decoration:underline;">lihat selengkapnya</button>
                                @endif

                                <div style="display:flex; flex-wrap:wrap; gap:0.35rem; margin-bottom:0.45rem; margin-top:0.45rem;">
                                    @if(is_array($item->tags) && count($item->tags) > 0)
                                        @foreach($item->tags as $tag)
                                            <span style="font-size:0.7rem; color:#dbeafe;">#{{ $tag }}</span>
                                        @endforeach
                                    @endif
                                </div>

                                <div style="display:flex; align-items:center; gap:0.4rem; color:#e2e8f0; font-size:0.72rem;">
                                    <span>🔊</span>
                                    <span>{{ $item->created_at->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>

                            <!-- Comments Panel (Right Sidebar - Outside Card) -->
                            <div class="commentsPanel" data-news-id="{{ $item->id }}" style="position:fixed; right:0; top:0; bottom:0; width:320px; background:linear-gradient(90deg, rgba(5,5,5,0.3) 0%, rgba(5,5,5,0.95) 30%, rgba(5,5,5,1) 100%); display:none; flex-direction:column; z-index:8; overflow:hidden;">
                                <!-- Comments Header -->
                                <div style="padding:1rem; border-bottom:1px solid rgba(255,255,255,0.1); background:rgba(5,5,5,0.9); font-weight:700; color:#fff; font-size:0.9rem;">
                                    💬 Komentar ({{ $item->comments()->count() }})
                                </div>

                                <!-- Comments list -->
                                <div class="commentsList" style="flex:1; overflow-y:auto; padding:1rem; scrollbar-width:thin;">
                                    @php $comments = $item->comments()->take(15)->get(); @endphp
                                    @if($comments->count() > 0)
                                        @foreach($comments as $comment)
                                            <div style="margin-bottom:0.8rem; padding-bottom:0.8rem; border-bottom:1px solid rgba(255,255,255,0.08);">
                                                <div style="display:flex; gap:0.5rem;">
                                                    <div style="width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg, #667eea 0%, #764ba2 100%); flex-shrink:0; display:flex; align-items:center; justify-content:center; color:#fff; font-size:0.75rem; font-weight:700;">{{ substr($comment->nama, 0, 1) }}</div>
                                                    <div style="flex:1; min-width:0;">
                                                        <div style="display:flex; align-items:baseline; gap:0.35rem; margin-bottom:0.2rem;">
                                                            <span style="color:#fff; font-weight:700; font-size:0.8rem;">{{ substr($comment->nama, 0, 20) }}</span>
                                                            <span style="color:#94a3b8; font-size:0.7rem;">{{ $comment->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p style="color:#e2e8f0; font-size:0.8rem; margin:0; word-break:break-word; line-height:1.3;">{{ $comment->komentar }}</p>
                                                        <div style="display:flex; gap:1rem; margin-top:0.35rem; font-size:0.7rem; color:#94a3b8; align-items:center; flex-wrap:wrap;">
                                                            <button type="button" style="background:none; border:none; color:#94a3b8; cursor:pointer; padding:0;">❤️ Suka</button>
                                                            <button type="button" style="background:none; border:none; color:#94a3b8; cursor:pointer; padding:0;">💬 Balas</button>
                                                            @auth
                                                                @if(auth()->user()->isAdmin() || auth()->id() === $comment->user_id)
                                                                    <button type="button" class="deleteCommentBtn" data-comment-id="{{ $comment->id }}" style="background:none; border:none; color:#fca5a5; cursor:pointer; padding:0; font-weight:700;">🗑 Hapus</button>
                                                                @endif
                                                            @endauth
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div style="text-align:center; color:#94a3b8; padding:2rem 1rem; font-size:0.85rem;">
                                            Belum ada komentar. Jadilah yang pertama! 👇
                                        </div>
                                    @endif
                                </div>

                                <!-- Add comment input -->
                                <div style="padding:0.75rem; border-top:1px solid rgba(255,255,255,0.1); background:rgba(5,5,5,0.95); display:flex; flex-direction:column; gap:0.5rem;">
                                    <input type="text" class="commentQuickNama" data-news-id="{{ $item->id }}" placeholder="Nama Anda" style="width:100%; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); color:#fff; font-size:0.8rem; outline:none; padding:0.4rem; border-radius:0.3rem;" maxlength="50">
                                    <div style="display:flex; gap:0.35rem;">
                                        <input type="text" class="commentQuickInput" data-news-id="{{ $item->id }}" placeholder="Tulis komentar..." style="flex:1; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); color:#fff; font-size:0.8rem; outline:none; padding:0.4rem; border-radius:0.3rem;" maxlength="500">
                                        <button type="button" class="commentQuickSubmit" data-news-id="{{ $item->id }}" style="background:#667eea; border:none; color:#fff; cursor:pointer; font-weight:700; font-size:0.75rem; padding:0.4rem 0.6rem; border-radius:0.3rem; transition:background 0.2s;">Kirim</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align:center; color:#9ca3af; padding:2rem;">
                <div style="font-size:3rem; margin-bottom:0.75rem;">📰</div>
                <p style="margin:0; color:#6b7280;">Belum ada berita yang dipublikasikan.</p>
            </div>
        @endif
    </div>

    <!-- Comment Modal -->
    <div id="commentModal" style="position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.7); display:none; align-items:center; justify-content:center; z-index:30;">
        <div style="background:#fff; border-radius:0.75rem; padding:1.5rem; max-width:400px; width:90%; box-shadow:0 20px 40px rgba(0,0,0,0.3);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                <h3 style="margin:0; font-size:1.25rem; color:#111;">Berikan Komentar</h3>
                <button type="button" onclick="document.getElementById('commentModal').style.display='none'" style="background:none; border:none; font-size:1.5rem; cursor:pointer; color:#999;">✕</button>
            </div>

            <form id="commentForm" style="display:flex; flex-direction:column; gap:0.75rem;">
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600; color:#374151; font-size:0.875rem;">Nama Anda</label>
                    <input type="text" id="commentNama" name="nama" placeholder="Masukkan nama Anda" required maxlength="100" style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:0.375rem; font-size:0.875rem;">
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600; color:#374151; font-size:0.875rem;">Komentar</label>
                    <textarea id="commentTeks" name="komentar" placeholder="Tulis komentar Anda..." required maxlength="500" rows="4" style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:0.375rem; font-size:0.875rem; font-family:inherit; resize:vertical;"></textarea>
                    <p style="color:#6b7280; font-size:0.75rem; margin:0.25rem 0 0; text-align:right;"><span id="charRemaining">500</span>/500</p>
                </div>

                <div style="display:flex; gap:0.75rem; margin-top:1rem;">
                    <button type="button" onclick="document.getElementById('commentModal').style.display='none'" style="flex:1; padding:0.5rem; border:1px solid #d1d5db; background:#f3f4f6; border-radius:0.375rem; cursor:pointer; font-weight:600; color:#374151;">Batal</button>
                    <button type="submit" style="flex:1; padding:0.5rem; border:none; background:#ef4444; color:#fff; border-radius:0.375rem; cursor:pointer; font-weight:600;">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Full Description Modal -->
    <div id="fullDescriptionModal" style="position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.8); display:none; align-items:center; justify-content:center; z-index:40; padding:1rem; animation:fadeInModal 0.3s ease;">
        <div style="background:linear-gradient(135deg, #0f172a 0%, #1a2847 100%); border-radius:1rem; padding:1.5rem; max-width:500px; width:100%; max-height:70vh; overflow-y:auto; box-shadow:0 25px 50px rgba(0,0,0,0.5); border:1px solid rgba(251,191,36,0.2);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                <h3 style="margin:0; font-size:1rem; color:#fbbf24; font-weight:700;">Keterangan Lengkap</h3>
                <button type="button" onclick="document.getElementById('fullDescriptionModal').style.display='none'" style="background:none; border:none; font-size:1.5rem; cursor:pointer; color:#fbbf24;">✕</button>
            </div>
            
            <div id="fullDescriptionContent" style="font-size:0.9rem; line-height:1.6; color:#e2e8f0; word-break:break-word; white-space:pre-wrap;">
                <!-- Content will be inserted here -->
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeInModal {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        #fullDescriptionModal > div {
            animation: slideUpModal 0.3s ease;
        }

        @keyframes slideUpModal {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</section>

<script>
let likedItems = {};
let isScrolling = false;
let scrollTimeout;

// Enhanced navigation function with proper paging
window.newsNavigate = function(direction) {
    if (isScrolling) return; // Prevent multiple scrolls
    
    const newsFeed = document.getElementById('newsFeed');
    if (!newsFeed) return;
    
    isScrolling = true;
    const itemHeight = window.innerHeight - 4; // Account for padding
    
    if (direction === 'next') {
        newsFeed.scrollTo({
            top: newsFeed.scrollTop + itemHeight,
            behavior: 'smooth'
        });
    } else if (direction === 'prev') {
        newsFeed.scrollTo({
            top: Math.max(0, newsFeed.scrollTop - itemHeight),
            behavior: 'smooth'
        });
    }
    
    // Reset scroll lock after animation
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(() => {
        isScrolling = false;
    }, 800);
};

// Vertical Swipe Detection
let touchStartY = 0;
let touchEndY = 0;

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartY - touchEndY;
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            window.newsNavigate('next'); // Swipe up = next
        } else {
            window.newsNavigate('prev'); // Swipe down = prev
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const newsFeed = document.getElementById('newsFeed');
    const params = new URLSearchParams(window.location.search);
    const selectedNewsId = params.get('news_id');

    if (!newsFeed) {
        console.error('newsFeed element not found');
        return;
    }

    if (selectedNewsId) {
        const selectedItem = document.querySelector(`.news-item[data-news-id="${selectedNewsId}"]`);
        if (selectedItem) {
            selectedItem.classList.add('is-selected');
            setTimeout(() => {
                selectedItem.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 180);

            const url = new URL(window.location.href);
            url.searchParams.delete('news_id');
            window.history.replaceState({}, '', url);
        }
    }

    // Keyboard Navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            window.newsNavigate('next');
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            window.newsNavigate('prev');
        }
    });

    // Swipe Support
    newsFeed.addEventListener('touchstart', (e) => {
        touchStartY = e.changedTouches[0].screenY;
    }, false);

    newsFeed.addEventListener('touchend', (e) => {
        touchEndY = e.changedTouches[0].screenY;
        handleSwipe();
    }, false);

    // Wheel/Mouse Scroll Event - for smooth one-item scroll
    let wheelTimeout;
    newsFeed.addEventListener('wheel', (e) => {
        if (isScrolling) {
            e.preventDefault();
            return;
        }
        
        e.preventDefault();
        clearTimeout(wheelTimeout);
        
        if (e.deltaY > 0) {
            window.newsNavigate('next');
        } else if (e.deltaY < 0) {
            window.newsNavigate('prev');
        }
        
        wheelTimeout = setTimeout(() => {
            isScrolling = false;
        }, 800);
    }, { passive: false });

    document.querySelectorAll('.galleryScroll').forEach(scroll => {
        const parent = scroll.closest('.news-item');
        const prevBtn = parent.querySelector('.galleryPrev');
        const nextBtn = parent.querySelector('.galleryNext');

        const updateSlideIndicator = () => {
            const width = scroll.offsetWidth;
            const index = Math.round(scroll.scrollLeft / width);
            const currentSlide = parent.querySelector('.currentSlide');
            if (currentSlide) {
                currentSlide.textContent = index + 1;
            }
            if (prevBtn) prevBtn.style.opacity = index === 0 ? '0.4' : '1';
            if (nextBtn) nextBtn.style.opacity = index >= (scroll.children.length - 1) ? '0.4' : '1';
        };

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                const width = scroll.offsetWidth;
                const index = Math.round(scroll.scrollLeft / width);
                scroll.scrollTo({ left: Math.max(0, (index - 1) * width), behavior: 'smooth' });
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                const width = scroll.offsetWidth;
                const index = Math.round(scroll.scrollLeft / width);
                const maxIndex = scroll.children.length - 1;
                scroll.scrollTo({ left: Math.min(maxIndex * width, (index + 1) * width), behavior: 'smooth' });
            });
        }

        scroll.addEventListener('scroll', updateSlideIndicator);
        updateSlideIndicator();
    });

    document.querySelectorAll('.likeBtn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const item = this.closest('.news-item');
            const newsId = item.dataset.newsId;
            const likeIcon = item.querySelector('.likeIcon');
            const likeCount = item.querySelector('.likeCount');

            if (!likedItems[newsId]) {
                fetch(`/api/news/${newsId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        likedItems[newsId] = true;
                        likeIcon.textContent = '❤';
                        this.style.background = 'linear-gradient(135deg, rgba(255,107,107,0.3) 0%, rgba(255,107,107,0.15) 100%)';
                        this.style.borderColor = '#ff6b6b';
                        likeCount.textContent = data.like_count;
                    }
                })
                .catch(err => console.error('Like error:', err));
            }
        });
    });

    document.querySelectorAll('.commentBtn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const item = this.closest('.news-item');
            const newsId = item.dataset.newsId;
            const commentsPanel = document.querySelector(`.commentsPanel[data-news-id="${newsId}"]`);

            // Hide all other panels
            document.querySelectorAll('.commentsPanel').forEach(panel => {
                if (panel.dataset.newsId !== newsId) {
                    panel.style.display = 'none';
                }
            });

            // Toggle current panel
            if (commentsPanel.style.display === 'flex') {
                commentsPanel.style.display = 'none';
            } else {
                commentsPanel.style.display = 'flex';
                // Focus on input
                setTimeout(() => {
                    const input = commentsPanel.querySelector('.commentQuickInput');
                    if (input) input.focus();
                }, 100);
            }
        });
    });

    // Quick comment submit
    document.querySelectorAll('.commentQuickSubmit').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const newsId = this.dataset.newsId;
            const panel = document.querySelector(`.commentsPanel[data-news-id="${newsId}"]`);
            const namaInput = panel.querySelector(`.commentQuickNama[data-news-id="${newsId}"]`);
            const komentarInput = panel.querySelector(`.commentQuickInput[data-news-id="${newsId}"]`);

            if (!namaInput.value.trim() || !komentarInput.value.trim()) {
                alert('Masukkan nama dan komentar');
                return;
            }

            fetch(`/api/news/${newsId}/comment`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    nama: namaInput.value,
                    komentar: komentarInput.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    namaInput.value = '';
                    komentarInput.value = '';
                    alert('✓ Komentar Anda berhasil dikirim!');
                    // Reload to show new comment
                    location.reload();
                }
            })
            .catch(err => {
                console.error('Comment error:', err);
                alert('❌ Gagal mengirim komentar');
            });
        });
    });

    document.querySelectorAll('.deleteCommentBtn').forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.dataset.commentId;
            const confirmed = confirm('Apakah Anda yakin ingin menghapus komentar ini?');
            if (!confirmed) return;

            fetch(`/api/news/comments/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(async response => {
                const data = await response.json().catch(() => ({}));
                if (!response.ok) {
                    throw new Error(data.message || 'Gagal menghapus komentar');
                }
                this.closest('div')?.closest('div')?.remove();
                alert('✓ Komentar berhasil dihapus');
                window.location.reload();
            })
            .catch(err => {
                console.error('Delete comment error:', err);
                alert(err.message || '❌ Gagal menghapus komentar');
            });
        });
    });

    document.querySelectorAll('.shareBtn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const item = this.closest('.news-item');
            const newsId = item.dataset.newsId;
            const count = item.querySelector('.shareCount');
            const title = item.querySelector('h2')?.textContent || 'Berita';
            const desc = item.querySelector('p')?.textContent || 'Berita';

            if (navigator.share) {
                navigator.share({ title, text: desc, url: window.location.href })
                    .then(() => {
                        fetch(`/api/news/${newsId}/share`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) count.textContent = data.share_count;
                        });
                    })
                    .catch(() => {});
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Link berhasil disalin');
                    fetch(`/api/news/${newsId}/share`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) count.textContent = data.share_count;
                    });
                });
            }
        });
    });

    // Read More Button Handler - Show Full Description in Modal
    document.querySelectorAll('.readMoreBtn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            
            const modal = document.getElementById('fullDescriptionModal');
            const contentDiv = document.getElementById('fullDescriptionContent');
            const description = this.getAttribute('data-description') || '';
            
            contentDiv.textContent = description;
            modal.style.display = 'flex';
        });
    });

    // Close modal when clicking outside
    document.getElementById('fullDescriptionModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('fullDescriptionModal').style.display = 'none';
        }
    });

    // Custom video controls - Play/Pause and Volume only
    document.querySelectorAll('.media-video').forEach((video) => {
        const volumeControl = video.parentElement?.querySelector('.volume-control');
        const volumeSlider = volumeControl?.querySelector('.volume-slider');
        const volumeIcon = volumeControl?.querySelector('.volume-icon');
        
        // Initialize volume
        if (volumeSlider && volumeIcon) {
            const initVolume = parseFloat(volumeSlider.value) / 100;
            video.volume = initVolume;
            updateVolumeIcon(volumeIcon, initVolume);
        }
        
        // Click to play/pause
        video.addEventListener('click', (e) => {
            e.stopPropagation();
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        });

        // Volume control
        if (volumeSlider) {
            volumeSlider.addEventListener('input', (e) => {
                e.stopPropagation();
                const vol = parseFloat(e.target.value) / 100;
                video.volume = vol;
                
                // Unmute when user changes volume > 0
                if (vol > 0) video.muted = false;
                
                updateVolumeIcon(volumeIcon, vol);
            });
        }
    });
    
    function updateVolumeIcon(icon, volume) {
        if (volume === 0) {
            icon.textContent = '🔇';
        } else if (volume < 0.5) {
            icon.textContent = '🔉';
        } else {
            icon.textContent = '🔊';
        }
    }

    // TikTok-style Auto Pause/Resume with Intersection Observer
    const videoObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const video = entry.target;
            if (entry.isIntersecting) {
                // Video is in view - auto play
                if (video.paused) {
                    video.play().catch(err => {
                        console.log('Auto-play prevented:', err.message);
                    });
                }
            } else {
                // Video is out of view - pause
                if (!video.paused) {
                    video.pause();
                }
            }
        });
    }, {
        threshold: [0.5] // Trigger when 50% of video is visible
    });

    // Observe all videos for vertical scroll (main feed)
    document.querySelectorAll('.media-video').forEach(video => {
        videoObserver.observe(video);
    });

    // Handle gallery horizontal scroll auto-pause
    document.querySelectorAll('.galleryScroll').forEach(gallery => {
        const galleryObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const video = entry.target.querySelector('.media-video');
                if (!video) return;
                
                if (entry.isIntersecting) {
                    // Gallery item is in view - auto play if parent card is visible
                    if (video.paused) {
                        video.play().catch(err => {
                            console.log('Auto-play prevented:', err.message);
                        });
                    }
                } else {
                    // Gallery item is out of view - pause
                    if (!video.paused) {
                        video.pause();
                    }
                }
            });
        }, {
            root: gallery, // Use gallery as root
            threshold: [0.5]
        });

        gallery.querySelectorAll('.gallery-item').forEach(item => {
            galleryObserver.observe(item);
        });
    });
});
</script>
@endsection

