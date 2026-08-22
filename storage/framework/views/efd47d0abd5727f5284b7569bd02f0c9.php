

<?php $__env->startSection('title', $news->judul . ' - Apotek Medistra Farma'); ?>

<?php $__env->startSection('content'); ?>
<section style="background: #000; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 0;">
    <div style="width: 100%; max-width: 520px; height: 100vh; max-height: 100vh; background: #000; position: relative; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.9); display: flex; flex-direction: column; border-radius: 0;">
        
        <!-- Header Bar -->
        <div style="padding: 0.75rem 1rem 0.5rem; display: flex; justify-content: space-between; align-items: center; z-index: 10; position: relative;">
            <a href="<?php echo e(route('news.index')); ?>" style="color: #fbbf24; text-decoration: none; font-weight: 700; font-size: 1.2rem; background: none; border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 999px; background: rgba(255,255,255,0.06);">←</a>
            <span style="color: #9ca3af; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;"><?php echo e($news->created_at->translatedFormat('d M Y')); ?></span>
        </div>

        <!-- Media Container -->
        <?php
            $galleryImages = is_array($news->gallery) ? $news->gallery : [];
            $displayMedia = $galleryImages ?: [$news->file];
        ?>

        <?php if(!empty($displayMedia)): ?>
            <div style="flex: 1; background: #000; position: relative; overflow: hidden; display: flex;">
                <?php if(count($displayMedia) > 1): ?>
                    <div style="display: flex; overflow-x: auto; scroll-snap-type: x mandatory; width: 100%; height: 100%; position: relative;" id="galleryScroll">
                        <?php $__currentLoopData = $displayMedia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $galleryItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($galleryItem && is_string($galleryItem)): ?>
                                <div style="min-width: 100%; height: 100%; scroll-snap-align: start; position: relative;">
                                    <?php if(str_contains(strtolower($galleryItem), '.mp4') || str_contains(strtolower($galleryItem), '.webm') || str_contains(strtolower($galleryItem), '.mov')): ?>
                                        <div style="position: relative; width: 100%; height: 100%;">
                                            <video class="media-video" playsinline style="display: block; width: 100%; height: 100%; background: #dfeaf2; object-fit: contain; cursor: pointer; z-index: 10;">
                                                <?php
                                                    $ext = strtolower(pathinfo($galleryItem, PATHINFO_EXTENSION));
                                                    $mimeType = match($ext) {
                                                        'webm' => 'video/webm',
                                                        'mov' => 'video/quicktime',
                                                        default => 'video/mp4'
                                                    };
                                                ?>
                                                <source src="<?php echo e(asset('storage/' . $galleryItem)); ?>" type="<?php echo e($mimeType); ?>">
                                                Browser Anda tidak mendukung video.
                                            </video>
                                            <div class="volume-control" style="position: absolute; right: 0.9rem; bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; z-index: 6; pointer-events: auto; background: rgba(0,0,0,0.3); padding: 0.45rem 0.7rem; border-radius: 999px; backdrop-filter: blur(8px);">
                                                <input type="range" class="volume-slider" min="0" max="100" value="70" style="width: 66px; height: 4px; accent-color: #fbbf24; cursor: pointer;">
                                                <div class="volume-icon" style="font-size: 1.2rem; color: #fbbf24; text-shadow: 0 2px 4px rgba(0,0,0,0.8); width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">🔊</div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('storage/' . $galleryItem)); ?>" alt="<?php echo e($news->judul); ?>" style="display: block; width: 100%; height: 100%; object-fit: contain; background: #dfeaf2; padding: 0.35rem;">
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div style="position: absolute; right: 0.75rem; top: 0.75rem; background: rgba(17,24,39,0.7); color: white; font-size: 0.7rem; border-radius: 999px; padding: 0.35rem 0.6rem; z-index: 5;">
                        <span id="currentSlide">1</span>/<?php echo e(count($displayMedia)); ?>

                    </div>
                <?php else: ?>
                    <?php $singleMedia = $displayMedia[0]; ?>
                    <?php if(str_contains(strtolower($singleMedia), '.mp4') || str_contains(strtolower($singleMedia), '.webm') || str_contains(strtolower($singleMedia), '.mov')): ?>
                        <div style="width: 100%; height: 100%; position: relative;">
                            <video class="media-video" playsinline style="display: block; width: 100%; height: 100%; background: #dfeaf2; object-fit: contain; cursor: pointer; z-index: 10;">
                                <?php
                                    $ext = strtolower(pathinfo($singleMedia, PATHINFO_EXTENSION));
                                    $mimeType = match($ext) {
                                        'webm' => 'video/webm',
                                        'mov' => 'video/quicktime',
                                        default => 'video/mp4'
                                    };
                                ?>
                                <source src="<?php echo e(asset('storage/' . $singleMedia)); ?>" type="<?php echo e($mimeType); ?>">
                                Browser Anda tidak mendukung video.
                            </video>
                            <div class="volume-control" style="position: absolute; right: 0.9rem; bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; z-index: 6; pointer-events: auto; background: rgba(0,0,0,0.3); padding: 0.45rem 0.7rem; border-radius: 999px; backdrop-filter: blur(8px);">
                                <input type="range" class="volume-slider" min="0" max="100" value="70" style="width: 66px; height: 4px; accent-color: #fbbf24; cursor: pointer;">
                                <div class="volume-icon" style="font-size: 1.2rem; color: #fbbf24; text-shadow: 0 2px 4px rgba(0,0,0,0.8); width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">🔊</div>
                            </div>
                        </div>
                    <?php else: ?>
                        <img src="<?php echo e(asset('storage/' . $singleMedia)); ?>" alt="<?php echo e($news->judul); ?>" style="display: block; width: 100%; height: 100%; object-fit: contain; background: #dfeaf2; padding: 0.35rem;">
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Gradient Overlay + Content at Bottom -->
                <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.4) 40%, rgba(0,0,0,0.9) 100%); z-index: 3; pointer-events: none;"></div>

                <!-- Right Sidebar (TikTok-style actions) -->
                <div style="position: absolute; right: 0.9rem; bottom: 7.1rem; display: flex; flex-direction: column; gap: 0.75rem; z-index: 5; align-items: center;">
                    <!-- Like Button -->
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.2rem;">
                        <button id="likeBtn" style="background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%); border: 1px solid rgba(255,255,255,0.1); border-radius: 50%; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; color: #ff6b6b; cursor: pointer; font-size: 1.2rem; transition: all 0.2s ease; backdrop-filter: blur(8px); box-shadow: 0 8px 24px rgba(0,0,0,0.25);" onmouseover="this.style.background='linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.12) 100%)'; this.style.transform='scale(1.08)'" onmouseout="this.style.background='linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%)'; this.style.transform='scale(1)'" onclick="toggleLike();">
                            <span id="likeIcon"><i class="fa-solid fa-heart"></i></span>
                        </button>
                        <div id="likeCount" style="color: #fff; font-size: 0.68rem; font-weight: 700; min-height: 0.8rem; line-height: 0.8rem; text-align: center;"><?php echo e($news->like_count > 0 ? $news->like_count : ''); ?></div>
                    </div>

                    <!-- Comment Button -->
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.2rem;">
                        <button style="background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%); border: 1px solid rgba(255,255,255,0.1); border-radius: 50%; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; color: #77d7ff; cursor: pointer; font-size: 1.1rem; transition: all 0.2s ease; backdrop-filter: blur(8px); box-shadow: 0 8px 24px rgba(0,0,0,0.25);" onmouseover="this.style.background='linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.12) 100%)'; this.style.transform='scale(1.08)'" onmouseout="this.style.background='linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%)'; this.style.transform='scale(1)'" onclick="toggleComment();">
                            <i class="fa-regular fa-comment"></i>
                        </button>
                        <div id="commentCount" style="color: #fff; font-size: 0.68rem; font-weight: 700; min-height: 0.8rem; line-height: 0.8rem; text-align: center;"><?php echo e($news->comment_count > 0 ? $news->comment_count : ''); ?></div>
                    </div>

                    <!-- Share Button -->
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.2rem;">
                        <button style="background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%); border: 1px solid rgba(255,255,255,0.1); border-radius: 50%; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; color: #fcd34d; cursor: pointer; font-size: 1.05rem; transition: all 0.2s ease; backdrop-filter: blur(8px); box-shadow: 0 8px 24px rgba(0,0,0,0.25);" onmouseover="this.style.background='linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.12) 100%)'; this.style.transform='scale(1.08)'" onmouseout="this.style.background='linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%)'; this.style.transform='scale(1)'" onclick="toggleShare();">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                        <div id="shareCount" style="color: #fff; font-size: 0.68rem; font-weight: 700; min-height: 0.8rem; line-height: 0.8rem; text-align: center;"><?php echo e($news->share_count > 0 ? $news->share_count : ''); ?></div>
                    </div>
                </div>

                <!-- Bottom Content Card -->
                <div id="contentCard" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(17,24,39,0.96) 24%, rgba(17,24,39,1) 100%); padding: 2.75rem 4.25rem 1rem 1rem; z-index: 4; max-height: 45%; display: flex; flex-direction: column; transition: max-height 0.3s ease-out; overflow-y: auto; overflow-x: hidden;">
                    <h1 style="margin: 0 0 0.55rem; font-size: 1rem; font-weight: 800; line-height: 1.35; color: #ffffff; flex-shrink: 0; word-wrap: break-word; overflow-wrap: break-word;"><?php echo e($news->judul); ?></h1>
                    
                    <div style="margin-bottom: 0.55rem; display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; flex-shrink: 0;">
                        <span style="background: rgba(251,191,36,0.16); color: #fbbf24; border: 1px solid rgba(251,191,36,0.2); padding: 0.3rem 0.6rem; border-radius: 999px; font-size: 0.65rem; font-weight: 700;">
                            <?php switch($news->tipe):
                                case ('video'): ?> 🎥 Video <?php break; ?>
                                <?php case ('galeri'): ?> 📸 Galeri <?php break; ?>
                                <?php default: ?> 📄 Artikel <?php endswitch; ?>
                        </span>
                    </div>

                    <div id="descriptionContainer" style="flex: 1; overflow: hidden; display: flex; flex-direction: column; min-height: 0;">
                        <p id="descriptionText" style="margin: 0 0 0.45rem 0; padding: 0; font-size: 0.8rem; line-height: 1.5; color: #e5e7eb; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; word-wrap: break-word; overflow-wrap: break-word; text-align: left; flex-shrink: 0; transition: -webkit-line-clamp 0.3s ease-out;"><?php echo e($news->deskripsi); ?></p>
                        <?php $deskripsiLength = strlen($news->deskripsi); ?>
                        <?php if($deskripsiLength > 150): ?>
                            <button id="readMoreBtn" onclick="toggleDescription()" style="background: none; border: none; color: #fbbf24; font-weight: 600; font-size: 0.72rem; padding: 0; margin: 0; cursor: pointer; text-decoration: underline; text-align: left; width: fit-content; flex-shrink: 0;">lihat selengkapnya</button>
                        <?php endif; ?>
                    </div>

                    <?php if(!empty($news->konten)): ?>
                        <div id="contentText" style="margin-top: 1rem; padding-top: 0.8rem; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.78rem; line-height: 1.6; color: #cbd5e1; white-space: pre-wrap; word-wrap: break-word; overflow-wrap: break-word; max-height: 8rem; overflow-y: auto; padding-right: 0.5rem; scrollbar-width: thin; display: none; text-align: left;"><?php echo e($news->konten); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>let liked = false;

function toggleLike() {
    const likeBtn = document.getElementById('likeBtn');
    const likeIcon = document.getElementById('likeIcon');
    const likeCount = document.getElementById('likeCount');
    const newsId = '<?php echo e($news->id); ?>';

    if (!liked) {
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
                liked = true;
                likeIcon.textContent = '❤';
                likeBtn.style.background = 'linear-gradient(135deg, rgba(255,107,107,0.3) 0%, rgba(255,107,107,0.15) 100%)';
                likeBtn.style.borderColor = '#ff6b6b';
                likeCount.textContent = data.like_count;
            }
        })
        .catch(err => console.error('Error:', err));
    }
}

function toggleComment() {
    const commentCount = document.getElementById('commentCount');
    const newsId = '<?php echo e($news->id); ?>';

    fetch(`/api/news/${newsId}/comment`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            commentCount.textContent = data.comment_count;
            alert('Terima kasih atas komentar Anda! Fitur komentar akan segera diluncurkan.');
        }
    })
    .catch(err => console.error('Error:', err));
}

function toggleShare() {
    const shareCount = document.getElementById('shareCount');
    const newsId = '<?php echo e($news->id); ?>';

    if (navigator.share) {
        navigator.share({
            title: '<?php echo e($news->judul); ?>',
            text: '<?php echo e($news->deskripsi); ?>',
            url: window.location.href
        }).then(() => {
            fetch(`/api/news/${newsId}/share`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    shareCount.textContent = data.share_count;
                }
            });
        }).catch(err => console.log('Share cancelled or error:', err));
    } else {
        // Fallback: Copy link to clipboard
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link berita telah disalin ke clipboard!');
            fetch(`/api/news/${newsId}/share`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    shareCount.textContent = data.share_count;
                }
            });
        }).catch(err => console.error('Error copying:', err));
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const scroll = document.getElementById('galleryScroll');
    if (scroll) {
        const slides = scroll.querySelectorAll('div[style*="min-width: 100%"]');
        let currentIndex = 0;
        
        scroll.addEventListener('scroll', function() {
            const scrollLeft = scroll.scrollLeft;
            const slideWidth = scroll.offsetWidth;
            currentIndex = Math.round(scrollLeft / slideWidth);
            document.getElementById('currentSlide').textContent = currentIndex + 1;
        });
    }

    // Custom video controls - Play/Pause and Volume
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

    // TikTok-style Auto Pause/Resume with Intersection Observer for gallery
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

    // Observe all videos
    document.querySelectorAll('.media-video').forEach(video => {
        videoObserver.observe(video);
    });
});

function toggleDescription() {
    const descText = document.getElementById('descriptionText');
    const readMoreBtn = document.getElementById('readMoreBtn');
    const contentCard = document.getElementById('contentCard');
    const contentText = document.getElementById('contentText');
    const descContainer = document.getElementById('descriptionContainer');
    
    if (descText.style.webkitLineClamp === 'unset' || descText.style.webkitLineClamp === '') {
        // Collapse
        descText.style.webkitLineClamp = '3';
        descText.style.overflow = 'hidden';
        descText.style.textOverflow = 'ellipsis';
        readMoreBtn.textContent = 'lihat selengkapnya';
        if (contentText) contentText.style.display = 'none';
        contentCard.style.maxHeight = '45%';
        contentCard.scrollTop = 0;
    } else {
        // Expand
        descText.style.webkitLineClamp = 'unset';
        descText.style.overflow = 'visible';
        descText.style.textOverflow = 'unset';
        readMoreBtn.textContent = 'sembunyikan';
        if (contentText) contentText.style.display = 'block';
        contentCard.style.maxHeight = '95vh';
        
        // Scroll to show description properly
        setTimeout(() => {
            const rect = descText.getBoundingClientRect();
            if (rect.top < 0) {
                contentCard.scrollTop = Math.max(0, contentCard.scrollTop + rect.top - 20);
            }
        }, 100);
    }
}
</script>
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views/news/show.blade.php ENDPATH**/ ?>