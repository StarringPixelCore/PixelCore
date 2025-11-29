<?php
if (empty($pager)) return;

$current = (int) $pager->getCurrentPage();
$pageCount = (int) $pager->getPageCount();
$perPage = (int) $pager->getPerPage();
$total = $pager->getTotal();

$start = ($current - 1) * $perPage + 1;
$end = min($current * $perPage, $total);

function page_url($pager, $i) {
    if (method_exists($pager, 'getPageURI')) {
        return $pager->getPageURI($i);
    }
    $uri = current_url();
    $query = $_GET;
    $query['page'] = $i;
    return $uri . '?' . http_build_query($query);
}

function render_page($pager, $i, $current) {
    $url = page_url($pager, $i);
    $active = ($i === $current);
    if ($active) {
        return "<a href=\"$url\" aria-current=\"page\" class=\"page-link active\">$i</a>";
    }
    return "<a href=\"$url\" class=\"page-link\">$i</a>";
}
?>

<style>
.tw-pag {
    background: transparent;
    padding: 1rem 0;
    display: block;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.tw-pag .small-controls {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.tw-pag .nav {
    display: inline-flex;
    gap: 0.25rem;
}

.tw-pag a {
    text-decoration: none;
    transition: all 0.15s ease;
}

.tw-pag .btn {
    padding: 0.5rem 1rem;
    color: #d1d5db;
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 0.375rem;
    font-weight: 400;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.15s ease;
}

.tw-pag .btn:hover {
    background: #347433;
    color: #fff;
}

.tw-pag .page-link {
    min-width: 2rem;
    height: 2rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 0.5rem;
    color: #9ca3af;
    background: transparent;
    border-radius: 0.25rem;
    font-weight: 400;
    font-size: 0.8125rem;
    transition: color 0.15s ease;
}

.tw-pag .page-link:hover {
    color: #e5e7eb;
}

.tw-pag .page-link.active {
    background: #1C7947;
    color: #fff;
    font-weight: 500;
}

.tw-pag .arrow-btn {
    min-width: 2rem;
    height: 2rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    color: #9ca3af;
    background: transparent;
    border-radius: 0.25rem;
    transition: color 0.15s ease;
}

.tw-pag .arrow-btn:hover {
    color: #e5e7eb;
}

.tw-pag .muted {
    color: #6b7280;
    padding: 0.5rem;
    cursor: not-allowed;
    opacity: 0.4;
}

.tw-pag .ellipsis {
    color: #6b7280;
    padding: 0.5rem 0.25rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 1.5rem;
    font-size: 0.8125rem;
}

.tw-pag .info {
    color: #9ca3af;
    font-size: 0.8125rem;
    font-weight: 400;
}

.tw-pag .info .font-medium {
    color: #d1d5db;
    font-weight: 500;
}

.tw-pag .desktop-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}

@media (max-width: 640px) {
    .tw-pag .desktop {
        display: none;
    }
    
    .tw-pag .btn {
        flex: 1;
        justify-content: center;
        display: flex;
    }
}

@media (min-width: 641px) {
    .tw-pag .mobile {
        display: none;
    }
}
</style>

<div class="tw-pag">
    <!-- Mobile view: Simple prev/next buttons -->
    <div class="mobile small-controls">
        <?php if ($current > 1): ?>
            <a href="<?= page_url($pager, $current-1) ?>" class="btn">← Previous</a>
        <?php else: ?>
            <span class="btn muted">← Previous</span>
        <?php endif; ?>

        <?php if ($current < $pageCount): ?>
            <a href="<?= page_url($pager, $current+1) ?>" class="btn">Next →</a>
        <?php else: ?>
            <span class="btn muted">Next →</span>
        <?php endif; ?>
    </div>

    <!-- Desktop view: Full pagination with info -->
    <div class="desktop desktop-container">
        
        <nav aria-label="Pagination" class="nav" role="navigation">
            <?php // Previous arrow ?>
            <?php if ($current > 1): ?>
                <a href="<?= page_url($pager, $current-1) ?>" class="arrow-btn page-link" aria-label="Previous">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            <?php else: ?>
                <span class="arrow-btn muted">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            <?php endif; ?>

            <?php
            // Render pages with smart windowing
            $window = 2;
            $left = max(1, $current - $window);
            $right = min($pageCount, $current + $window);

            // Always show first page
            if ($left > 1) {
                echo render_page($pager, 1, $current);
                if ($left > 2) echo "<span class=\"ellipsis\">...</span>";
            }

            // Show window around current page
            for ($i = $left; $i <= $right; $i++) {
                echo render_page($pager, $i, $current);
            }

            // Always show last page
            if ($right < $pageCount) {
                if ($right < $pageCount - 1) echo "<span class=\"ellipsis\">...</span>";
                echo render_page($pager, $pageCount, $current);
            }
            ?>

            <?php // Next arrow ?>
            <?php if ($current < $pageCount): ?>
                <a href="<?= page_url($pager, $current+1) ?>" class="arrow-btn page-link" aria-label="Next">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            <?php else: ?>
                <span class="arrow-btn muted">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            <?php endif; ?>
        </nav>
    </div>
</div>