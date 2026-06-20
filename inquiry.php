<?php
include "./include/session.php";
include "./include/connection.php";

?>
<!doctype html>
<html lang="en">
<!-- Head Links start Here -->
<?php include "./include/head_links.php" ?>
<!-- Head Links start Here -->

<style>
    /* Reset and Base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        min-height: 100vh;
        background: #f0f2f8;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        position: relative;
        overflow-x: hidden;
        color: #1a1a2e;
    }

    /* ========== PARALLAX BLUR BACKGROUND - MULTI-COLOR ========== */
    .parallax-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        overflow: hidden;
        background: linear-gradient(135deg, #f0f2f8 0%, #e8ecf5 30%, #f5f7fc 60%, #eef1fa 100%);
    }

    /* ====== 8 DIFFERENT COLOR ORBS ====== */
    .parallax-bg .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        will-change: transform, opacity;
        animation: floatOrb 20s ease-in-out infinite alternate;
        opacity: 0.35;
    }

    /* Orb 1 - Blue/Primary */
    .parallax-bg .orb:nth-child(1) {
        width: 450px;
        height: 450px;
        top: -8%;
        left: -5%;
        background: radial-gradient(circle, rgba(85, 110, 230, 0.3), rgba(85, 110, 230, 0.05));
        animation-duration: 25s;
        animation-delay: 0s;
    }

    /* Orb 2 - Green/Success */
    .parallax-bg .orb:nth-child(2) {
        width: 500px;
        height: 500px;
        bottom: -12%;
        right: -6%;
        background: radial-gradient(circle, rgba(52, 195, 143, 0.25), rgba(52, 195, 143, 0.04));
        animation-duration: 28s;
        animation-delay: -3s;
    }

    /* Orb 3 - Red/Danger */
    .parallax-bg .orb:nth-child(3) {
        width: 380px;
        height: 380px;
        top: 35%;
        left: 55%;
        transform: translateX(-50%);
        background: radial-gradient(circle, rgba(244, 106, 106, 0.2), rgba(244, 106, 106, 0.03));
        animation-duration: 22s;
        animation-delay: -7s;
    }

    /* Orb 4 - Yellow/Warning */
    .parallax-bg .orb:nth-child(4) {
        width: 280px;
        height: 280px;
        top: 15%;
        right: 18%;
        background: radial-gradient(circle, rgba(255, 193, 7, 0.25), rgba(255, 193, 7, 0.04));
        animation-duration: 19s;
        animation-delay: -4s;
    }

    /* Orb 5 - Purple */
    .parallax-bg .orb:nth-child(5) {
        width: 300px;
        height: 300px;
        bottom: 25%;
        left: 8%;
        background: radial-gradient(circle, rgba(156, 39, 176, 0.2), rgba(156, 39, 176, 0.03));
        animation-duration: 26s;
        animation-delay: -10s;
    }

    /* Orb 6 - Orange */
    .parallax-bg .orb:nth-child(6) {
        width: 220px;
        height: 220px;
        top: 55%;
        right: 30%;
        background: radial-gradient(circle, rgba(255, 152, 0, 0.2), rgba(255, 152, 0, 0.03));
        animation-duration: 21s;
        animation-delay: -6s;
    }

    /* Orb 7 - Teal/Cyan */
    .parallax-bg .orb:nth-child(7) {
        width: 260px;
        height: 260px;
        top: 5%;
        left: 40%;
        background: radial-gradient(circle, rgba(0, 188, 212, 0.2), rgba(0, 188, 212, 0.03));
        animation-duration: 24s;
        animation-delay: -12s;
    }

    /* Orb 8 - Pink */
    .parallax-bg .orb:nth-child(8) {
        width: 200px;
        height: 200px;
        bottom: 10%;
        left: 45%;
        background: radial-gradient(circle, rgba(233, 30, 99, 0.18), rgba(233, 30, 99, 0.03));
        animation-duration: 20s;
        animation-delay: -8s;
    }

    /* Grid overlay for depth */
    .parallax-bg .grid-overlay {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(0, 0, 0, 0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 0, 0, 0.02) 1px, transparent 1px);
        background-size: 60px 60px;
        opacity: 0.6;
    }

    @keyframes floatOrb {
        0% {
            transform: translate(0, 0) scale(1);
            opacity: 0.35;
        }

        25% {
            transform: translate(40px, -25px) scale(1.15);
            opacity: 0.5;
        }

        50% {
            transform: translate(-25px, 45px) scale(0.85);
            opacity: 0.3;
        }

        75% {
            transform: translate(45px, 15px) scale(1.2);
            opacity: 0.45;
        }

        100% {
            transform: translate(-15px, -35px) scale(1);
            opacity: 0.35;
        }
    }

    /* ========== GLASSMORPHISM CORE - LIGHT MODE ========== */
    .glass-card {
        background: rgba(255, 255, 255, 0.7) !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        border: 1px solid rgba(255, 255, 255, 0.8) !important;
        box-shadow:
            0 8px 32px 0 rgba(31, 38, 135, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.9) !important;
        border-radius: 16px !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .glass-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        padding: 1px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.6));
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
    }

    .glass-card:hover {
        border-color: rgba(255, 255, 255, 0.95) !important;
        box-shadow:
            0 12px 48px 0 rgba(31, 38, 135, 0.12),
            0 0 30px rgba(85, 110, 230, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.95) !important;
    }

    /* Glass Inputs - Light Mode */
    .glass-input {
        background: rgba(255, 255, 255, 0.6) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border: 1px solid rgba(255, 255, 255, 0.9) !important;
        border-bottom: 2px solid rgba(85, 110, 230, 0.3) !important;
        border-radius: 10px !important;
        color: #1a1a2e !important;
        padding: 10px 16px !important;
        transition: all 0.3s ease;
        background-clip: padding-box;
    }

    .glass-input:focus {
        background: rgba(255, 255, 255, 0.85) !important;
        border-color: rgba(85, 110, 230, 0.3) !important;
        box-shadow: 0 0 0 4px rgba(85, 110, 230, 0.08), 0 4px 20px rgba(85, 110, 230, 0.08) !important;
        outline: none;
        transform: translateY(-1px);
    }

    .glass-input::placeholder {
        color: rgba(0, 0, 0, 0.35) !important;
    }

    .glass-input option {
        background: #ffffff;
        color: #1a1a2e;
    }

    .glass-input select {
        cursor: pointer;
    }

    /* Glass Table - Light */
    .glass-table {
        background: transparent !important;
    }

    .glass-table th,
    .glass-table td {
        background: rgba(255, 255, 255, 0.5) !important;
        border-color: rgba(0, 0, 0, 0.06) !important;
        color: #1a1a2e !important;
        padding: 12px 16px !important;
        transition: background 0.2s ease;
    }

    .glass-table th {
        background: rgba(85, 110, 230, 0.08) !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #1a1a2e !important;
    }

    .glass-table td:hover {
        background: rgba(255, 255, 255, 0.7) !important;
    }

    .glass-table .table-dark {
        background: rgba(0, 0, 0, 0.05) !important;
    }

    .glass-table .table-dark th {
        background: rgba(0, 0, 0, 0.08) !important;
        color: #1a1a2e !important;
    }

    /* Glass Header - Light */
    .glass-header {
        background: rgba(85, 110, 230, 0.06) !important;
        backdrop-filter: blur(8px);
        border-bottom: 1px solid rgba(85, 110, 230, 0.1) !important;
        padding: 16px 24px !important;
    }

    .glass-header h4 {
        color: #1a1a2e !important;
        font-weight: 700;
        letter-spacing: 0.5px;
        -webkit-text-fill-color: #1a1a2e;
    }

    /* ========== CUSTOM BUTTONS - LIGHT ========== */
    .btn-glass-primary {
        background: linear-gradient(135deg, rgba(85, 110, 230, 0.15), rgba(85, 110, 230, 0.05)) !important;
        border: 1px solid rgba(85, 110, 230, 0.2) !important;
        color: #556ee6 !important;
        padding: 10px 28px !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        backdrop-filter: blur(8px);
        box-shadow: 0 4px 15px rgba(85, 110, 230, 0.08) !important;
    }

    .btn-glass-primary:hover {
        background: linear-gradient(135deg, rgba(85, 110, 230, 0.25), rgba(85, 110, 230, 0.1)) !important;
        border-color: rgba(85, 110, 230, 0.4) !important;
        color: #3d4fbf !important;
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 30px rgba(85, 110, 230, 0.15) !important;
    }

    .btn-glass-primary i {
        color: #556ee6;
    }

    /* Back Button - Light */
    .btn-back {
        background: rgba(255, 255, 255, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.8) !important;
        color: #1a1a2e !important;
        backdrop-filter: blur(12px);
        padding: 10px 20px !important;
        border-radius: 12px !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04) !important;
    }

    .btn-back:hover {
        background: rgba(85, 110, 230, 0.1) !important;
        border-color: rgba(85, 110, 230, 0.2) !important;
        transform: translateX(-4px);
        box-shadow: 0 4px 20px rgba(85, 110, 230, 0.08) !important;
        color: #556ee6 !important;
    }

    /* ========== TEXT STYLES - LIGHT ========== */
    .text-gradient-primary {
        background: linear-gradient(135deg, #556ee6, #3d4fbf);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .text-gradient-success {
        background: linear-gradient(135deg, #34c38f, #2a9d7a);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .text-gradient-danger {
        background: linear-gradient(135deg, #f46a6a, #d63031);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .text-primary-solid {
        color: #556ee6 !important;
    }

    .text-success-solid {
        color: #34c38f !important;
    }

    .text-danger-solid {
        color: #f46a6a !important;
    }

    /* ========== SCROLLBAR - LIGHT ========== */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.03);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(85, 110, 230, 0.2);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(85, 110, 230, 0.4);
    }

    /* ========== RESPONSIVE TWEAKS ========== */
    @media (max-width: 768px) {
        .parallax-bg .orb {
            filter: blur(60px);
        }

        .parallax-bg .orb:nth-child(1) {
            width: 280px;
            height: 280px;
        }

        .parallax-bg .orb:nth-child(2) {
            width: 320px;
            height: 320px;
        }

        .parallax-bg .orb:nth-child(3) {
            width: 220px;
            height: 220px;
        }

        .parallax-bg .orb:nth-child(4) {
            width: 180px;
            height: 180px;
        }

        .parallax-bg .orb:nth-child(5) {
            width: 200px;
            height: 200px;
        }

        .parallax-bg .orb:nth-child(6) {
            width: 160px;
            height: 160px;
        }

        .parallax-bg .orb:nth-child(7) {
            width: 180px;
            height: 180px;
        }

        .parallax-bg .orb:nth-child(8) {
            width: 150px;
            height: 150px;
        }

        .glass-card {
            border-radius: 12px !important;
        }
    }

    /* ========== PRELOADER ========== */
    #preloader {
        background: #f0f2f8;
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        overflow-y: auto;
        padding: 30px 15px;
    }

    /* ===== INQUIRY PAGE CUSTOM SKELETON LOADER ===== */
    @keyframes inq-shimmer {
        0% {
            background-position: -600px 0;
        }

        100% {
            background-position: 600px 0;
        }
    }

    .inq-sk-shine {
        background: linear-gradient(90deg, #e8ecf5 25%, #f5f7fc 50%, #e8ecf5 75%);
        background-size: 600px 100%;
        animation: inq-shimmer 1.6s infinite;
        border-radius: 8px;
    }

    .inquiry-skeleton-wrapper {
        width: 100%;
        max-width: 1140px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding-top: 10px;
    }

    /* Back button */
    .inq-sk-back {
        width: 100px;
        height: 38px;
        background: linear-gradient(90deg, #e8ecf5 25%, #f5f7fc 50%, #e8ecf5 75%);
        background-size: 600px 100%;
        animation: inq-shimmer 1.6s infinite;
        border-radius: 8px;
    }

    /* Filter card */
    .inq-sk-card {
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.7);
        border-radius: 16px;
        padding: 24px;
        width: 100%;
    }

    .inq-sk-row {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .inq-sk-field {
        flex: 1;
        min-width: 140px;
        height: 52px;
        background: linear-gradient(90deg, #e8ecf5 25%, #f5f7fc 50%, #e8ecf5 75%);
        background-size: 600px 100%;
        animation: inq-shimmer 1.6s infinite;
        border-radius: 10px;
    }

    .inq-sk-btn {
        width: 130px;
        height: 52px;
        background: linear-gradient(90deg, #c5cef5 25%, #d8dff9 50%, #c5cef5 75%);
        background-size: 600px 100%;
        animation: inq-shimmer 1.6s infinite;
        border-radius: 10px;
        flex-shrink: 0;
    }

    /* Results row */
    .inq-sk-results {
        align-items: flex-start;
    }

    .inq-sk-half {
        flex: 1;
        min-width: 280px;
    }

    .inq-sk-card-header {
        height: 44px;
        background: linear-gradient(90deg, #e8ecf5 25%, #f5f7fc 50%, #e8ecf5 75%);
        background-size: 600px 100%;
        animation: inq-shimmer 1.6s infinite;
        border-radius: 8px;
        margin-bottom: 16px;
    }

    .inq-sk-table-row {
        height: 38px;
        background: linear-gradient(90deg, #eef1f8 25%, #f5f7fc 50%, #eef1f8 75%);
        background-size: 600px 100%;
        animation: inq-shimmer 1.6s infinite;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    .inq-sk-summary-row {
        height: 54px;
        background: linear-gradient(90deg, #eef1f8 25%, #f5f7fc 50%, #eef1f8 75%);
        background-size: 600px 100%;
        animation: inq-shimmer 1.6s infinite;
        border-radius: 8px;
        margin-bottom: 12px;
    }

    @media (max-width: 767px) {
        .inq-sk-half {
            min-width: 100%;
        }

        .inq-sk-field {
            min-width: 100%;
        }

        .inq-sk-btn {
            width: 100%;
        }
    }


    /* ========== FOOTER - LIGHT ========== */
    .footer.glass-card {
        background: rgba(255, 255, 255, 0.5) !important;
        backdrop-filter: blur(16px) !important;
        border-top: 1px solid rgba(255, 255, 255, 0.6) !important;
        padding: 16px 0 !important;
    }

    .footer a {
        color: #556ee6 !important;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .footer a:hover {
        color: #3d4fbf !important;
        transform: scale(1.05);
    }

    .text-light-emphasis {
        color: #1a1a2e !important;
    }

    /* ========== BREADCRUMB OVERRIDE - LIGHT ========== */
    .breadcrumb-item {
        color: rgba(0, 0, 0, 0.4) !important;
    }

    .breadcrumb-item.active {
        color: rgba(0, 0, 0, 0.6) !important;
    }

    .breadcrumb-item a {
        color: #556ee6 !important;
    }

    /* Table input overrides for light */
    .glass-table input.form-control {
        background: transparent !important;
        color: #1a1a2e !important;
    }

    .glass-table input.form-control.fw-bold.text-primary {
        color: #556ee6 !important;
    }

    .glass-table input.form-control.fw-bold.text-success {
        color: #34c38f !important;
    }

    .bg-primary.bg-opacity-10 {
        background: rgba(85, 110, 230, 0.08) !important;
    }

    .bg-white.bg-opacity-5 {
        background: rgba(255, 255, 255, 0.5) !important;
    }

    .border-light {
        border-color: rgba(0, 0, 0, 0.06) !important;
    }

    .bg-warning.bg-opacity-25 {
        background: rgba(255, 193, 7, 0.08) !important;
    }

    .bg-info.bg-opacity-25 {
        background: rgba(13, 202, 240, 0.08) !important;
    }

    .border-warning {
        border-color: rgba(255, 193, 7, 0.2) !important;
    }

    .border-info {
        border-color: rgba(13, 202, 240, 0.2) !important;
    }

    .text-secondary {
        color: #6c757d !important;
    }

    .text-dark {
        color: #1a1a2e !important;
    }
</style>

<body data-sidebar="dark" class="d-flex flex-column min-vh-100">

    <!-- ====== PARALLAX BLUR BACKGROUND - MULTI-COLOR ====== -->
    <div class="parallax-bg">
        <!-- 8 Different Color Orbs -->
        <div class="orb"></div> <!-- Blue -->
        <div class="orb"></div> <!-- Green -->
        <div class="orb"></div> <!-- Red -->
        <div class="orb"></div> <!-- Yellow -->
        <div class="orb"></div> <!-- Purple -->
        <div class="orb"></div> <!-- Orange -->
        <div class="orb"></div> <!-- Teal/Cyan -->
        <div class="orb"></div> <!-- Pink -->
        <div class="grid-overlay"></div>
    </div>

    <!-- Inquiry Skeleton Loader -->
    <div id="preloader" data-skeleton-type="inquiry">
        <div class="inquiry-skeleton-wrapper">
            <!-- Back button skeleton -->
            <div class="inq-sk-back"></div>

            <!-- Filter form card skeleton -->
            <div class="inq-sk-card">
                <div class="inq-sk-row">
                    <div class="inq-sk-field"></div>
                    <div class="inq-sk-field"></div>
                    <div class="inq-sk-field"></div>
                    <div class="inq-sk-btn"></div>
                </div>
            </div>

            <!-- Results section skeleton -->
            <div class="inq-sk-row inq-sk-results">
                <div class="inq-sk-half">
                    <div class="inq-sk-card">
                        <div class="inq-sk-card-header"></div>
                        <div class="inq-sk-table-row"></div>
                        <div class="inq-sk-table-row"></div>
                        <div class="inq-sk-table-row"></div>
                        <div class="inq-sk-table-row"></div>
                        <div class="inq-sk-table-row"></div>
                    </div>
                </div>
                <div class="inq-sk-half">
                    <div class="inq-sk-card">
                        <div class="inq-sk-card-header"></div>
                        <div class="inq-sk-summary-row"></div>
                        <div class="inq-sk-summary-row"></div>
                        <div class="inq-sk-summary-row"></div>
                        <div class="inq-sk-summary-row"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== MAIN CONTENT ====== -->
    <div class="container mt-4 position-relative" style="z-index: 1;">

        <!-- Back Button -->
        <div class="mb-3">
            <a href="javascript:history.back()" class="btn btn-back shadow-sm">
                <i class="mdi mdi-arrow-left me-2"></i> Back
            </a>
        </div>

        <!-- Filter Form -->
        <div class="card glass-card p-4 mb-4">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="fw-semibold text-dark mb-2" style="font-size:0.85rem; letter-spacing:0.3px;">
                            <i class="mdi mdi-account me-1"></i> Customer ID
                        </label>
                        <input type="text" name="id" class="form-control glass-input" placeholder="Enter Your ID">
                    </div>
                    <div class="col-md-4">
                        <label class="fw-semibold text-dark mb-2" style="font-size:0.85rem; letter-spacing:0.3px;">
                            <i class="mdi mdi-calendar me-1"></i> Select Year
                        </label>
                        <select class="form-select glass-input" name="year" id="yearSelect">
                            <option selected hidden>-- Select Year --</option>
                            <?php
                            $sqlYear = "SELECT DISTINCT YEAR(created_at) AS sale_year FROM sale WHERE created_at IS NOT NULL ORDER BY sale_year DESC";
                            $resultYear = mysqli_query($conn, $sqlYear);
                            while ($rowYear = mysqli_fetch_assoc($resultYear)) {
                                echo '<option value="' . $rowYear['sale_year'] . '">' . $rowYear['sale_year'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-semibold text-dark mb-2" style="font-size:0.85rem; letter-spacing:0.3px;">
                            <i class="mdi mdi-calendar-month me-1"></i> Select Month
                        </label>
                        <select class="form-select glass-input" name="month" id="monthSelect">
                            <option selected hidden>-- Select Year First --</option>
                        </select>
                    </div>
                    <div class="col-12 mt-3 text-center">
                        <button type="submit" class="btn btn-glass-primary w-50 m-auto shadow-sm">
                            <i class="mdi mdi-magnify me-2"></i> Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ====== PAGE CONTENT ====== -->
    <div class="page-content flex-grow-1 position-relative" style="z-index: 1;">
        <?php
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $month  = $_POST['month'];
            $year   = $_POST['year'];
            if ($id == "" || $month == "" || $year == "") {
                echo "<script>alert('All Fields Are Required!!');
                window.location.href = 'inquiry.php';</script>";
            }
        ?>

            <form action="#" method="POST">
                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between glass-card p-3 mb-4">
                                <h4 class="mb-sm-0 font-size-18 text-dark fw-bold">
                                    <i class="mdi mdi-file-document-outline me-2 text-primary-solid"></i>View Bill
                                </h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active text-dark">Other Details</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Row -->
                    <div class="row g-4">
                        <!-- Left Column: Supply Data -->
                        <div class="col-xl-6">
                            <div class="card glass-card">
                                <div class="card-header glass-header text-center">
                                    <h4 class="mb-0 text-dark fw-bold">
                                        <i class="mdi mdi-truck-delivery me-2 text-primary-solid"></i>Supply Data
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <!-- Rate & Previous Empty -->
                                    <table class="table glass-table">
                                        <thead>
                                            <tr class="text-center">
                                                <th class="text-dark" style="font-size:0.8rem;">Per Can Rate</th>
                                                <th class="text-dark" style="font-size:0.8rem;">Previous Empty Can.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td class="text-dark fs-4 fw-bold">
                                                    <?php
                                                    $sqlRate = "SELECT rate FROM sale WHERE customer = $id AND MONTH(created_at) = $month AND YEAR(created_at) = $year";
                                                    $resultRate = mysqli_query($conn, $sqlRate);
                                                    if ($rowRate = mysqli_fetch_assoc($resultRate)) {
                                                        echo $rowRate['rate'];
                                                    } else {
                                                        echo 0;
                                                    }
                                                    ?>
                                                </td>
                                                <td class="fs-4 fw-bold text-dark">
                                                    <?php
                                                    $preE = 0;
                                                    $sqlpre = "SELECT sum(D) as D, sum(R) as R FROM sale WHERE MONTH(created_at) = MONTH(DATE_ADD('$year-$month-01', INTERVAL -1 MONTH)) AND YEAR(created_at) = YEAR(DATE_ADD('$year-$month-01', INTERVAL -1 MONTH)) AND customer = $id";
                                                    $result = mysqli_query($conn, $sqlpre);
                                                    if ($row = mysqli_fetch_array($result)) {
                                                        echo $preE = (int)$row['D'] - (int)$row['R'];
                                                        echo '<input type="hidden" class="preE" value="' . $preE . '">';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Main Table -->
                                    <div class="table-responsive mt-3">
                                        <table class="table mb-0 table-bordered table-hover glass-table">
                                            <thead class="table-dark bg-opacity-10">
                                                <tr>
                                                    <th class="text-dark">Date</th>
                                                    <th class="text-dark">Deliver</th>
                                                    <th class="text-dark">Return</th>
                                                    <th class="text-dark">Paid</th>
                                                    <th class="text-dark">Empty Can.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $paid = 0;
                                                $Rcan = 0;
                                                $can = 0;
                                                $Tcan = 0;
                                                $query = "SELECT `D`,`R`,`paid_ammount`,`paid_ammount_date`,`created_at`,`id` as id from `sale` Where month(created_at) = $month and year(created_at) = $year and customer = $id";
                                                $result = mysqli_query($conn, $query);
                                                if ($result) {
                                                    $data = array_fill(0, 31, array('D' => '', 'R' => '', 'paid_ammount' => '', 'id' => ''));
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $day = date('d', strtotime($row['created_at'])) - 1;
                                                        $data[$day] = $row;
                                                    }
                                                    foreach ($data as $day => $value) {
                                                        $Tcan += (int)$value['D'];
                                                        $Rcan += (int)$value['R'];
                                                ?>
                                                        <tr>
                                                            <th scope="row">
                                                                <input type="number" class="form-control border-0 bg-transparent fw-bold text-dark" name="day[]" value="<?php echo $day + 1 ?>" readonly>
                                                            </th>
                                                            <td>
                                                                <input type="number" name="can_deliver[]" class="form-control border-0 bg-transparent text-dark can_deliver<?php echo $day + 1 ?>" onkeyup="get_D(<?php echo $day + 1 ?>)" value="<?php echo (int)$value['D']; ?>" readonly>
                                                            </td>
                                                            <td><input type="number" name="can_return[]" class="form-control border-0 bg-transparent can_return<?php echo $day + 1 ?>" value="<?php echo (int)$value['R']; ?>" onkeyup="get_R(<?php echo $day + 1 ?>)" readonly></td>
                                                            <td><input type="number" class="form-control <?php if ((int)$value['paid_ammount'] > 0) {
                                                                                                                echo "fw-bold text-success";
                                                                                                            } else {
                                                                                                                echo "text-dark";
                                                                                                            } ?> border-0 bg-transparent paid_ammount<?php echo $day + 1 ?>" value="<?php echo (int)$value['paid_ammount']; ?>" name="paid[]" readonly></td>
                                                            <td>
                                                                <input type="number" name="empty_can[]" class="form-control border-0 bg-transparent fw-bold text-dark empty_can<?php echo $day + 1 ?>" value="<?php echo $Tcan - $Rcan + $preE; ?>" readonly>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $can += (int)$value['D'];
                                                        $paid += (int)$value['paid_ammount'];
                                                    }
                                                }
                                                ?>
                                                <input type="hidden" value="<?php echo $id ?>" name="uid">
                                                <input type="hidden" value="<?php echo $month ?>" name="month">
                                                <input type="hidden" value="<?php echo $year ?>" name="year">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Customer & Payment Detail -->
                        <?php
                        $sql = "SELECT c.`name` FROM `customer` c inner join `sale` s on c.id = s.customer  WHERE c.id = $id";
                        $result  = mysqli_query($conn, $sql);
                        if ($row = mysqli_fetch_array($result)) {
                        ?>
                            <div class="col-xl-6">
                                <div class="card glass-card">
                                    <div class="card-header glass-header text-center">
                                        <h4 class="mb-0 text-dark fw-bold">
                                            <i class="mdi mdi-account-box me-2 text-primary-solid"></i>Customer Detail
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table mb-4 glass-table">
                                            <thead>
                                                <tr>
                                                    <th class="text-dark">Customer Name</th>
                                                    <th class="text-dark">Month</th>
                                                    <th class="text-dark">Year</th>
                                                    <th class="text-dark">Code</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="bg-primary bg-opacity-10 text-dark fw-semibold">
                                                    <td><?php echo $row['name'] ?></td>
                                                    <td><?php echo date('F', strtotime('1-' . $month . '-' . $year)) ?></td>
                                                    <td><?php echo date('Y', strtotime('1-' . $month . '-' . $year)) ?></td>
                                                    <td class="text-danger fw-bold"><?php echo $_POST['id'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table mb-4 glass-table">
                                            <thead>
                                                <tr>
                                                    <th class="text-dark">Month</th>
                                                    <th class="text-dark">Total Cans</th>
                                                    <th class="text-dark">Per Can Rate</th>
                                                    <th class="text-dark">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="bg-primary bg-opacity-10 text-dark fw-semibold">
                                                    <td><?php echo date('F', strtotime('1-' . $month . '-' . $year)) ?></td>
                                                    <td><?php echo $Tcan;?></td>
                                                    <td class="text-danger fw-bold"><?php echo $rowRate['rate']?></td>
                                                    <td class="text-danger"><?= $Tcan*$rowRate['rate'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- Payment Detail -->
                                        <div class="row mt-3">
                                            <div class="card-header glass-header text-center">
                                                <h4 class="mb-0 text-dark fw-bold">
                                                    <i class="mdi mdi-cash me-2 text-primary-solid"></i>Payment Detail
                                                </h4>
                                            </div>
                                        </div>

                                        <div class="p-3 bg-white bg-opacity-50 rounded-3 mt-3" style="backdrop-filter: blur(8px); border: 1px solid rgba(0,0,0,0.04);">
                                            <div class="row mt-2 align-items-center py-2">
                                                <div class="col-6 text-end border-end border-dark border-opacity-10">
                                                    <h6 class="p-1 mb-0 fw-bold text-secondary">Previous Bal.</h6>
                                                </div>
                                                <div class="col-6 text-start ps-3">
                                                    <h6 class="p-1 mb-0 fw-bold text-dark">
                                                        <?php
                                                        $pre = 0;
                                                        $total = 0;
                                                        $sqlpre = "SELECT sum(s.`D`) as D,s.rate as rate, sum(s.paid_ammount) as paid FROM sale s INNER JOIN customer c on s.customer = c.id WHERE c.id = $id AND MONTH(s.created_at) = MONTH(DATE_ADD('$year-$month-01', INTERVAL -1 MONTH)) AND YEAR(s.created_at) = YEAR(DATE_ADD('$year-$month-01', INTERVAL -1 MONTH))";
                                                        $resultBill = mysqli_query($conn, $sqlpre);
                                                        if ($rowBill = mysqli_fetch_array($resultBill)) {
                                                            echo $pre = (int)$rowBill['D'] * (int)$rowBill['rate'] - (int)$rowBill['paid'];
                                                        }
                                                        ?>
                                                    </h6>
                                                </div>
                                            </div>
                                            <hr class="opacity-25">
                                            <div class="row align-items-center py-2">
                                                <div class="col-6 text-end border-end border-dark border-opacity-10">
                                                    <h6 class="p-1 mb-0 fw-bold text-secondary">Current Bal.</h6>
                                                </div>
                                                <div class="col-6 text-start ps-3">
                                                    <h6 class="p-1 mb-0 fw-bold text-dark">
                                                        <?php
                                                        $total = $can * (int)($rowRate['rate'] ?? 0);
                                                        echo $total;
                                                        ?>
                                                    </h6>
                                                </div>
                                            </div>
                                            <hr class="opacity-25">
                                            <div class="row align-items-center py-2">
                                                <div class="col-6 text-end border-end border-dark border-opacity-10">
                                                    <h6 class="p-1 mb-0 fw-bold text-secondary">Paid Amount.</h6>
                                                </div>
                                                <div class="col-6 text-start ps-3">
                                                    <h6 class="p-1 mb-0 fw-bold text-gradient-success"><?php echo $paid ?></h6>
                                                </div>
                                            </div>
                                            <hr class="opacity-25">
                                            <div class="row align-items-center py-2">
                                                <div class="col-6 text-end border-end border-dark border-opacity-10">
                                                    <h6 class="p-1 mb-0 fw-bold text-gradient-danger">Total Bal.</h6>
                                                </div>
                                                <div class="col-6 text-start ps-3">
                                                    <h6 class="p-1 mb-0 fw-bold fs-4 text-gradient-danger"><?php echo $pre + $total - $paid ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </form>
        <?php
        }
        ?>
    </div>

    <!-- ====== FOOTER ====== -->
    <footer class="footer glass-card mt-auto py-3 position-relative" style="z-index:1; border-radius:0 !important;left:0 !important;">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="text-sm-center d-none d-sm-block fw-bold text-dark" style="font-size:0.9rem;">
                        Design & Develop with <i class="bi bi-heart-fill text-danger"></i> by
                        <a href="<?php echo (defined('APP_URL') ? APP_URL : 'http://localhost/aquify'); ?>" class="text-decoration-none"><?php echo (defined('APP_NAME') ? APP_NAME : 'Aquify'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- ====== SCRIPT ====== -->
    <script>
        document.getElementById('yearSelect').addEventListener('change', function() {
            let selectedYear = this.value;
            let monthSelect = document.getElementById('monthSelect');
            monthSelect.innerHTML = '<option selected hidden>Loading...</option>';
            if (selectedYear) {
                fetch('<?php echo (defined('APP_URL') ? APP_URL : "/aquify"); ?>/ajax/get_months.php?year=' + selectedYear)
                    .then(response => response.text())
                    .then(data => {
                        monthSelect.innerHTML = '<option selected hidden>-- Select Month --</option>' + data;
                    })
                    .catch(error => {
                        console.error('Error fetching months:', error);
                        monthSelect.innerHTML = '<option selected hidden>Error loading months</option>';
                    });
            } else {
                monthSelect.innerHTML = '<option selected hidden>-- Select Year First --</option>';
            }
        });
    </script>

    <!-- Footer Link Start Here-->
    <?php include "./include/footer_link.php" ?>
    <!-- Footer Link End Here-->
</body>

</html>