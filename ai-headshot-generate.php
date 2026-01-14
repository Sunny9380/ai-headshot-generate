<?php
    session_start();
    if (!$_SESSION['userid']) {
        header("location:login.php");
        exit();
    }
    $_SESSION['LAST_ACTIVITY'] = time();
    include 'partials/layout-pre.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Headshot Generator</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tracking.js/1.1.3/tracking-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tracking.js/1.1.3/data/face-min.js"></script>
    <style>
        /* header-banner start */
        .header-hero{
            height: 500px; 
            position:relative;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #2e2e2f;
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat;
        }
        .hero-content{
            position:relative;
            z-index:1; 
            text-align:center; 
            color:#fff;
        }
        .header-hero .hero-title{
            font-size:42px; 
            font-weight:800;
        }
        .header-hero .hero-desc{
            margin:14px auto; 
            max-width:615px;
        }
        .header-hero .hero-desc span{
            font-size:16px; 
            color:#f5f7fc;
        }
        .personal-brand-hero{
            background-image: url('/images/dashboard-header/Developing-a-Personal-Brand.png'); 
        }

        /* Headshot Generator Styles */

        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --text-color: #ffffff;
            --text-secondary: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        .headshot-body {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-color);
            padding: 20px;
        }

        .headshot-container {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 900px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 10px;
            background: linear-gradient(to right, #fff, #e2e8f0);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .face-status {
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.6);
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .face-status::before {
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
        }

        .face-status.success {
            background: rgba(16, 185, 129, 0.25);
            color: #6ee7b7;
            border: 1px solid #059669;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.2);
        }

        .face-status.success::before {
            content: "\f00c";
        }

        .face-status.error {
            background: rgba(239, 68, 68, 0.25);
            color: #fca5a5;
            border: 1px solid #b91c1c;
        }

        .face-status.error::before {
            content: "\f071";
        }

        .face-status.warning {
            background: rgba(245, 158, 11, 0.25);
            color: #fcd34d;
            border: 1px solid #d97706;
        }

        .face-status.warning::before {
            content: "\f12a";
        }

        .main-content {
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
        }

        .upload-section,
        .result-section {
            flex: 1;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .upload-area {
            border: 2px dashed var(--glass-border);
            border-radius: 15px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
        }

        .upload-area:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .upload-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            color: var(--text-secondary);
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .preview-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 10px;
            display: none;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
        }

        .secondary-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 15px;
        }

        .secondary-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .cancel-btn {
            background: #ef4444;
        }

        .cancel-btn:hover {
            background: #dc2626;
        }

        .camera-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            background: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        video {
            width: 100%;
            border-radius: 10px;
            transform: scaleX(-1);
        }

        .video-wrapper {
            position: relative;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
        }

        #overlayCanvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transform: scaleX(-1);
        }

        .camera-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .result-container {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            min-height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .generated-image {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            border-radius: 15px;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 15px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .status-text {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .error-message {
            color: #ff6b6b;
            background: rgba(255, 0, 0, 0.1);
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            display: none;
            text-align: center;
        }

        /* Gender Toggle Styles */
        .gender-toggle {
            transition: all 0.3s ease;
        }

        .gender-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 211, 153, 0.2);
        }

        .gender-toggle.active {
            box-shadow: 0 0 10px rgba(52, 211, 153, 0.4);
        }

        /* Clothing Category Styles */
        .clothing-category {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .clothing-category:hover {
            transform: translateY(-2px);
        }

        .clothing-item {
            transition: all 0.3s ease;
        }

        .clothing-item:hover {
            background: rgba(0, 0, 0, 0.3) !important;
        }

        /* Slider Button Styles */
        .slider-btn {
            transition: all 0.3s ease;
        }

        .slider-btn:hover {
            background: rgba(52, 211, 153, 0.5) !important;
            transform: scale(1.1);
        }

        .slider-btn:active {
            transform: scale(0.95);
        }

        /* Tab buttons for clothing categories */
        .tab-btn {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(255, 255, 255, 0.2);
            padding: 10px 16px !important;
            font-size: 0.95rem !important;
            font-weight: 500 !important;
            letter-spacing: 0.5px !important;
            text-transform: capitalize !important;
            width: auto;
            margin: 0;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-left: 12px !important;
            padding-right: 12px !important;
        }

        .tab-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
        }

        .tab-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Persistent gallery selection styling */
        #galleryViewport.selected {
            border-color: rgba(52, 211, 153, 0.85) !important;
            background-color: rgba(52, 211, 153, 0.06) !important;
            box-shadow: 0 6px 20px rgba(52,211,153,0.06);
        }


        /* Small buttons for slider arrows */
        .btn.small {
            padding: 8px 12px !important;
            font-size: 1rem !important;
            font-weight: 600 !important;
            width: auto !important;
            text-transform: none !important;
            letter-spacing: normal !important;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .btn.small:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Gender toggle buttons */
        #genderMale, #genderFemale {
            flex: 1;
            padding: 10px 16px !important;
            font-size: 0.95rem !important;
            font-weight: 500 !important;
            width: auto !important;
            text-transform: capitalize !important;
            letter-spacing: 0.5px !important;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
        }

        #genderMale:hover, #genderFemale:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
        }

        #genderMale.active, #genderFemale.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        /* ===== RESPONSIVE DESIGN ===== */

        /* Tablets (768px - 1024px) */
        @media (max-width: 1024px) {
            .headshot-container {
                padding: 30px;
                gap: 25px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .subtitle {
                font-size: 1rem;
            }
        }

        /* Mobile devices (below 768px) */
        @media (max-width: 768px) {
            body {
                padding: 10px;
                align-items: flex-start;
                min-height: auto;
            }
            
            .headshot-container {
                padding: 20px;
                gap: 20px;
                border-radius: 15px;
                max-width: 100%;
            }
            
            header {
                margin-bottom: 10px;
            }
            
            h1 {
                font-size: 1.5rem;
                margin-bottom: 8px;
            }
            
            .subtitle {
                font-size: 0.9rem;
                margin-bottom: 15px;
                line-height: 1.4;
            }
            
            .main-content {
                gap: 20px;
            }
            
            .upload-section {
                gap: 15px;
            }
            
            .upload-area {
                padding: 20px;
            }
            
            .upload-area h3 {
                font-size: 1rem;
            }
            
            .upload-area p {
                font-size: 0.85rem;
            }
            
            .upload-icon {
                font-size: 2rem;
            }
            
            .btn {
                padding: 12px 20px;
                font-size: 1rem;
                letter-spacing: 0.5px;
            }
            
            .btn.small {
                padding: 8px 12px !important;
                font-size: 0.9rem !important;
            }
            
            .camera-container {
                padding: 12px;
                gap: 12px;
            }
            
            #video, #overlayCanvas {
                border-radius: 8px;
            }
            
            .camera-actions {
                gap: 10px;
            }
            
            .camera-actions .btn {
                font-size: 0.95rem;
                padding: 10px 15px;
            }
            
            .clothing-options {
                margin: 15px 0;
            }
            
            .clothing-options label {
                font-size: 0.95rem !important;
            }
            
            /* Gender toggle */
            div[style*="margin-bottom:10px"] {
                gap: 8px !important;
            }
            
            #genderMale, #genderFemale {
                padding: 10px 12px !important;
                font-size: 0.9rem !important;
            }
            
            /* Category tabs */
            div[style*="display:flex; gap:8px; margin-bottom:12px"] {
                flex-wrap: wrap;
                gap: 6px !important;
            }
            
            .tab-btn {
                padding: 8px 12px !important;
                font-size: 0.85rem !important;
                flex: 1;
                min-width: 80px;
            }
            
            /* Slider/Gallery */
            #clothingGallery {
                gap: 8px !important;
            }
            
            #galleryViewport {
                height: 250px !important;
                padding: 10px !important;
            }
            
            #galleryImage {
                max-width: 180px !important;
                max-height: 180px !important;
            }
            
            #galleryTitle {
                font-size: 12px !important;
                margin-top: 6px !important;
            }
            
            #selectHint {
                font-size: 10px !important;
                margin-top: 6px !important;
            }
            
            #styleInfo {
                margin-top: 10px !important;
                padding: 10px !important;
                font-size: 12px !important;
            }
            
            #generateBtn {
                padding: 12px 20px;
                font-size: 1rem;
                margin-top: 10px;
            }
            
            /* Result section */
            .result-section {
                gap: 15px;
            }
            
            .result-container {
                padding: 15px;
                border-radius: 12px;
            }
            
            #generatedImage {
                max-width: 100%;
                border-radius: 10px;
            }
            
            #downloadLink {
                padding: 12px 20px;
                font-size: 1rem;
            }
            
            .loading-overlay {
                border-radius: 12px;
            }
            
            .spinner {
                width: 40px;
                height: 40px;
            }
            
            .status-text {
                font-size: 0.95rem;
            }
            
            .error-message {
                padding: 12px;
                font-size: 0.9rem;
                margin-bottom: 15px;
            }
        }

        /* Small phones (below 480px) */
        @media (max-width: 480px) {
            body {
                padding: 8px;
            }
            
            .headshot-container {
                padding: 15px;
                gap: 15px;
                border-radius: 12px;
            }
            
            h1 {
                font-size: 1.25rem;
                margin-bottom: 6px;
            }
            
            .subtitle {
                font-size: 0.8rem;
                margin-bottom: 12px;
                line-height: 1.3;
            }
            
            .upload-area {
                padding: 15px;
            }
            
            .upload-icon {
                font-size: 1.5rem;
            }
            
            .btn {
                padding: 10px 16px;
                font-size: 0.9rem;
                letter-spacing: 0px;
            }
            
            .btn.small {
                padding: 6px 10px !important;
                font-size: 0.8rem !important;
            }
            
            .tab-btn {
                padding: 6px 10px !important;
                font-size: 0.75rem !important;
                min-width: 70px;
            }
            
            #genderMale, #genderFemale {
                padding: 8px 10px !important;
                font-size: 0.8rem !important;
            }
            
            #galleryViewport {
                height: 220px !important;
                padding: 8px !important;
            }
            
            #galleryImage {
                max-width: 150px !important;
                max-height: 150px !important;
            }
            
            #galleryTitle {
                font-size: 11px !important;
                margin-top: 4px !important;
            }
            
            #selectHint {
                font-size: 9px !important;
                margin-top: 4px !important;
            }
            
            #styleInfo {
                margin-top: 8px !important;
                padding: 8px !important;
                font-size: 11px !important;
                border-left-width: 2px !important;
            }
            
            #generateBtn {
                padding: 10px 16px;
                font-size: 0.9rem;
                margin-top: 8px;
            }
            
            #video {
                border-radius: 6px;
            }
            
            .camera-actions {
                gap: 8px;
            }
            
            .camera-actions .btn {
                font-size: 0.85rem;
                padding: 8px 12px;
            }
            
            .spinner {
                width: 35px;
                height: 35px;
            }
            
            .status-text {
                font-size: 0.9rem;
            }
            
            #downloadLink {
                padding: 10px 16px;
                font-size: 0.9rem;
            }
        }

        /* Extra small phones (below 360px) */
        @media (max-width: 360px) {
            .headshot-container {
                padding: 12px;
                gap: 12px;
            }
            
            h1 {
                font-size: 1.1rem;
            }
            
            .subtitle {
                font-size: 0.75rem;
            }
            
            .tab-btn {
                padding: 6px 8px !important;
                font-size: 0.7rem !important;
                min-width: 60px;
            }
            
            #galleryViewport {
                height: 200px !important;
            }
            
            #galleryImage {
                max-width: 130px !important;
                max-height: 130px !important;
            }
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<section>
    <div class="header-hero personal-brand-hero">
        <div class="hero-content">
            <div class="hero-title">
                AI Headshot Generator
            </div>
            <div class="hero-desc">
                <span>
                    You no longer have to go to a headshot photo booth. Now, you can obtain a high quality professional
                    headshot in minutes. You can then use your new headshot to enhance your online social media
                    presence, and improve your job search success!
                </span>
            </div>
        </div>
    </div>
</section>

<div class="headshot-body">
    <div class="headshot-container">
        <div class="main-content">
            <div class="upload-section">
                <form id="uploadForm" enctype="multipart/form-data">
                    <div class="upload-area" id="dropZone">
                        <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                        <h3>Click or Drag & Drop</h3>
                        <p>Upload a clear selfie (JPG, PNG)</p>
                        <input type="file" name="image" id="imageInput" class="file-input" accept="image/*">
                        <img id="preview" class="preview-image" alt="Preview">
                    </div>

                    <div class="camera-controls">
                        <button type="button" id="startCameraBtn" class="btn secondary-btn">Use Camera</button>
                    </div>

                    <div id="cameraContainer" class="camera-container" style="display: none;">
                        <div class="video-wrapper">
                            <video id="video" autoplay playsinline></video>
                            <canvas id="overlayCanvas"></canvas>
                        </div>
                        <canvas id="canvas" style="display: none;"></canvas>
                        <div class="camera-actions">
                            <button type="button" id="captureBtn" class="btn" disabled>
                                <i class="fa-solid fa-camera-retro"></i> Capture
                            </button>
                            <button type="button" id="closeCameraBtn" class="btn cancel-btn">
                                Cancel
                            </button>
                        </div>
                        <div id="faceStatus" class="face-status">Initializing camera...</div>
                    </div>
                    
                    <div id="errorMessage" class="error-message"></div>

                    <div class="clothing-options" style="margin: 20px 0;">
                        <label style="display:block; margin-bottom:8px; color: rgba(255,255,255,0.9); font-weight: 600;">
                            <i class="fa-solid fa-shirt"></i> Clothing Selection:
                        </label>

                        <!-- Gender Toggle -->
                        <div style="margin-bottom:10px; display:flex; gap:8px; flex-wrap:wrap;">
                            <button type="button" id="genderMale" class="btn secondary-btn small" style="flex:1; min-width:80px;">Male</button>
                            <button type="button" id="genderFemale" class="btn secondary-btn small" style="flex:1; min-width:80px;">Female</button>
                        </div>

                        <!-- Category Tabs -->
                        <div style="display:flex; gap:8px; margin-bottom:12px; flex-wrap:wrap; justify-content:space-between;">
                            <button type="button" class="btn tab-btn" data-category="business" style="flex:1; min-width:80px; white-space:nowrap;">Business</button>
                            <button type="button" class="btn tab-btn" data-category="business-casual" style="min-width:150px; white-space:nowrap;">Business Casual</button>
                            <button type="button" class="btn tab-btn" data-category="casual" style="flex:1; min-width:75px; white-space:nowrap;">Casual</button>
                            <button type="button" class="btn tab-btn" data-category="same" style="flex:1; min-width:90px; white-space:nowrap;">Keep Same Clothes</button>
                        </div>

                        <!-- Slider / Gallery -->
                        <div id="clothingGallery" style="position:relative; display:none; align-items:center; gap:12px;">
                            <button type="button" id="prevItem" class="btn small">◀</button>
                            <div id="galleryViewport" style="flex:1; text-align:center; height:280px; display:flex; flex-direction:column; justify-content:center; align-items:center; cursor:pointer; padding:15px; border-radius:8px; border:2px solid rgba(255,255,255,0.2); transition: all 0.3s ease;" onclick="selectCurrentItem()">
                                <div id="galleryLoader" style="display:none; text-align:center;">
                                    <div style="width:50px; height:50px; border:4px solid rgba(52,211,153,0.2); border-top:4px solid #34d399; border-radius:50%; animation:spin 1s linear infinite; margin:0 auto 15px;"></div>
                                    <div style="color:rgba(255,255,255,0.7); font-size:13px;">Loading images...</div>
                                </div>
                                <img id="galleryImage" src="" alt="clothing option" style="max-width:220px; max-height:220px; border-radius:8px; display:block; margin:0 auto; object-fit:contain;">
                                <div id="galleryTitle" style="color: rgba(255,255,255,0.9); margin-top:8px; font-size:13px; min-height:30px;"></div>
                                <div id="selectHint" style="margin-top:8px; font-size:11px; color:rgba(52,211,153,0.8); font-style:italic;">Tap to select</div>
                            </div>
                            <button type="button" id="nextItem" class="btn small">▶</button>
                        </div>

                        <!-- Hidden inputs to submit selection (keep `clothingStyle` id for server compatibility) -->
                        <input type="hidden" id="clothingStyle" name="clothingStyle" value="business">
                        <input type="hidden" id="clothingGender" name="clothingGender" value="male">
                        <input type="hidden" id="clothingChoice" name="clothingChoice" value="">
                        <input type="hidden" id="clothingFilename" name="clothingFilename" value="">

                        <div id="styleInfo" style="margin-top: 12px; padding: 12px; background: rgba(0,0,0,0.2); border-radius: 8px; border-left: 3px solid #34d399; font-size: 13px; color: rgba(255,255,255,0.8); line-height: 1.6;">
                            <strong style="color: #34d399;">Style Guide:</strong><br>
                            <span id="styleDescription">Select a category and pick an outfit from the slider. Use gender toggle to switch options.</span>
                        </div>
                    </div>

                    <button type="submit" class="btn" id="generateBtn">Generate Headshot</button>
                </form>
            </div>

            <div class="result-section">
                <div class="result-container" id="resultContainer">
                    <div class="loading-overlay" id="loadingOverlay">
                        <div class="spinner"></div>
                        <p class="status-text" id="statusText">Analyzing your profile...</p>
                    </div>
                    <p style="color: rgba(255,255,255,0.5);" id="placeholderText">Generated image will appear here</p>
                    <img id="generatedImage" class="generated-image" style="display: none;">
                </div>
                <a id="downloadLink" class="btn" style="display: none; text-align: center; text-decoration: none;">
                    <i class="fa-solid fa-download"></i> Download HD
                </a>
            </div>
        </div>
    </div>
</div>

<script>
        const imageInput = document.getElementById('imageInput');
        const preview = document.getElementById('preview');
        const uploadForm = document.getElementById('uploadForm');
        const generateBtn = document.getElementById('generateBtn');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const statusText = document.getElementById('statusText');
        const resultContainer = document.getElementById('resultContainer');
        const generatedImage = document.getElementById('generatedImage');
        const placeholderText = document.getElementById('placeholderText');
        const errorMessage = document.getElementById('errorMessage');
        const downloadLink = document.getElementById('downloadLink');
        
        // Camera Elements
        const startCameraBtn = document.getElementById('startCameraBtn');
        const cameraContainer = document.getElementById('cameraContainer');
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const overlayCanvas = document.getElementById('overlayCanvas');
        const overlayCtx = overlayCanvas.getContext('2d');
        const captureBtn = document.getElementById('captureBtn');
        const closeCameraBtn = document.getElementById('closeCameraBtn');
        const dropZone = document.getElementById('dropZone');
        const faceStatus = document.getElementById('faceStatus');
        const clothingStyle = document.getElementById('clothingStyle');
        const styleDescription = document.getElementById('styleDescription');
        let stream = null;
        let tracker = null;
        let trackerTask = null;

        // Style descriptions for men and women
        const styleDescriptions = {
            'same': {
                men: 'Keeps your original clothing exactly as shown in the photo',
                women: 'Keeps your original clothing exactly as shown in the photo'
            },
            'business': {
                men: '👔 Men: Dark business suit jacket, white/light dress shirt, tie',
                women: '👔 Women: Professional blazer or suit jacket with dress shirt or blouse'
            },
            'casual': {
                men: '👕 Men: Polo shirt, button-down shirt, or casual blazer',
                women: '👕 Women: Blouse, casual top, or casual blazer'
            },
            // 'formal': {
            //     men: '🎩 Men: Tuxedo or formal suit',
            //     women: '👗 Women: Elegant formal dress or evening gown'
            // },
            'business-casual': {
                men: '🧥 Men: Blazer or sport coat with dress shirt (no tie)',
                women: '🧥 Women: Blazer with blouse or professional top'
            }
        };

        // Clothing gallery + gender handling (image slider instead of dropdown)
        const galleryImage = document.getElementById('galleryImage');
        const galleryTitle = document.getElementById('galleryTitle');
        const prevItem = document.getElementById('prevItem');
        const nextItem = document.getElementById('nextItem');
        const clothingGender = document.getElementById('clothingGender');
        const clothingChoice = document.getElementById('clothingChoice');
        const clothingStyleHidden = document.getElementById('clothingStyle');

        // Dynamic clothing options - loads from folder structure
        // Structure: images/{gender}/{category}/{filename}.png
        const clothingLabels = {
            // Business & Business-Casual (both male & female)
            'beige-cream': 'Beige Cream',
            'black': 'Black',
            'bottle-green': 'Bottle Green',
            'camel-brown': 'Camel Brown',
            'charcoal-grey': 'Charcoal Grey',
            'coffee-brown': 'Coffee Brown',
            'dark-brown': 'Dark Brown',
            'grey-checkered': 'Grey Checkered',
            'light-grey': 'Light Grey',
            'maroon': 'Maroon',
            'maroon-wine': 'Maroon Wine',
            'navy-blue': 'Navy Blue',
            'olive-green': 'Olive Green',
            'royal-blue': 'Royal Blue',
            'sky-blue': 'Sky Blue',
            'steel-blue': 'Steel Blue',
            // Male Casual
            'black_t-shirt': 'Black T-Shirt',
            'brown_casual_shirt': 'Brown Casual Shirt',
            'charcoal_grey_casual_shirt': 'Charcoal Grey Casual Shirt',
            'dark_green_t-shirt': 'Dark Green T-Shirt',
            'grey_hoodie': 'Grey Hoodie',
            'light_blue_denim_shirt': 'Light Blue Denim Shirt',
            'maroon_casual_shirt': 'Maroon Casual Shirt',
            'mustard_yellow_t-shirt': 'Mustard Yellow T-Shirt',
            'navy_blue_polo_t-shirt': 'Navy Blue Polo T-Shirt',
            'olive_green_casual_shirt': 'Olive Green Casual Shirt',
            'sky_blue_polo_t-shirt': 'Sky Blue Polo T-Shirt',
            'white_t-shirt': 'White T-Shirt',
            // Female Casual
            'casual-1': 'Casual Style 1',
            'casual-2': 'Casual Style 2',
            'casual-3': 'Casual Style 3',
            'casual-4': 'Casual Style 4',
            'casual-5': 'Casual Style 5',
            'casual-6': 'Casual Style 6',
            'casual-7': 'Casual Style 7',
            'casual-8': 'Casual Style 8',
            'casual-9': 'Casual Style 9',
            'casual-10': 'Casual Style 10',
            'casual-11': 'Casual Style 11',
            'casual-12': 'Casual Style 12',
            'casual-13': 'Casual Style 13'
        };

        // suitColor/tieColor mapping removed; UI sends exact clothing image filename

        let currentGender = 'male';
        let currentCategory = 'business';
        let currentIndex = 0;
        let currentClothingList = [];
        // Persisted selection index (null when none). Holds selected item until changed or photo taken.
        let persistSelectedIndex = null;

        // Load images from folder structure dynamically
        async function loadClothingOptions(gender, category) {
            const folderPath = `headshot-photo/images/${gender}/${category}`;
            showGalleryLoader();
            disableAllButtons(true);
            
            try {
                // Special case: 'same' means keep the clothes in the uploaded photo
                if (category === 'same') {
                    currentClothingList = [{
                        id: `${gender}_same_use_original`,
                        title: 'Use the Clothes I am Wearing',
                        img: 'headshot-photo/images/same.png',
                        isSame: true
                    }];
                    currentIndex = 0;
                    renderGallery();
                    document.getElementById('clothingGallery').style.display = 'flex';
                    hideGalleryLoader();
                    disableAllButtons(false);
                    return;
                }
                // Define files for each category and gender
                let possibleFiles = []; 
                
                if (gender === 'male') {
                    if (category === 'business') {
                        possibleFiles = ['beige-cream.png','black.png','bottle-green.png','charcoal-grey.png','coffee-brown.png','dark-brown.png','grey-checkered.png','light-grey.png','maroon.png','navy-blue.png','olive-green.png','royal-blue.png', 'steel-blue.png'];    
                    } else if (category === 'business-casual') {
                        possibleFiles = ['beige-cream.png','black.png','camel-brown.png','charcoal-grey.png','dark-brown.png','grey-checkered.png','light-grey.png','maroon-wine.png','navy-blue.png','olive-green.png','royal-blue.png','sky-blue.png'];
                    } else if (category === 'casual') {
                        possibleFiles = ['black_t-shirt.png','brown_casual_shirt.png','charcoal_grey_casual_shirt.png','dark_green_t-shirt.png','grey_hoodie.png','light_blue_denim_shirt.png','maroon_casual_shirt.png','mustard_yellow_t-shirt.png','navy_blue_polo_t-shirt.png','olive_green_casual_shirt.png','sky_blue_polo_t-shirt.png','white_t-shirt.png'];
                    } 
                } else if (gender === 'female') {
                    if (category === 'business') {
                        possibleFiles = ['beige-cream.png','black.png','bottle-green.png','charcoal-grey.png','coffee-brown.png','dark-brown.png','light-grey.png','maroon.png','navy-blue.png','olive-green.png','royal-blue.png','steel-blue.png'];
                    } else if (category === 'business-casual') {
                        possibleFiles = ['beige-cream.png','black.png','camel-brown.png','dark-brown.png','grey-checkered.png','light-grey.png','maroon-wine.png','navy-blue.png','olive-green.png','royal-blue.png','sky-blue.png'];
                    } else if (category === 'casual') {
                        possibleFiles = ['casual-1.png','casual-2.png','casual-3.png','casual-4.png','casual-5.png','casual-6.png','casual-7.png','casual-8.png','casual-9.png','casual-10.png','casual-11.png','casual-12.png','casual-13.png'];
                    }
                }
                
                const loadedItems = [];
                let loadedCount = 0;

                for (const file of possibleFiles) {
                    const imgPath = `${folderPath}/${file}`;
                    // Try to load the image by creating an Image object
                    const img = new Image();
                    img.onload = function() {
                        const baseName = file.replace('.png', '');
                        const title = clothingLabels[baseName] || baseName;

                        loadedItems.push({
                            id: `${gender}_${category}_${baseName}`,
                            title: title,
                            img: imgPath
                        });
                        
                        loadedCount++;
                        // Check if all images have finished loading (success or fail)
                        if (loadedCount === possibleFiles.length) {
                            // All images processed, now add surprise option for business categories
                            if ((category === 'business' || category === 'business-casual' || category === 'casual') && (gender === 'male' || gender === 'female')) {
                                loadedItems.push({
                                    id: `${gender}_${category}_surprise`,
                                    title: 'Surprise Me!',
                                    img: 'headshot-photo/images/surprise.png',
                                    isSurprise: true
                                });
                            }
                            
                            // Update the list
                            if (loadedItems.length > 0) {
                                currentClothingList = loadedItems;
                            }
                            
                            // Re-render if this is the current selection
                            if (currentGender === gender && currentCategory === category) {
                                currentIndex = 0;
                                renderGallery();
                                document.getElementById('clothingGallery').style.display = 'flex';
                                hideGalleryLoader();
                                disableAllButtons(false);
                            }
                        }
                    };
                    img.onerror = function() {
                        loadedCount++;
                        // Check if all images have finished loading (success or fail)
                        if (loadedCount === possibleFiles.length) {
                            // All images processed, now add surprise option for business categories
                            if ((category === 'business' || category === 'business-casual' || category === 'casual') && (gender === 'male' || gender === 'female')) {
                                loadedItems.push({
                                    id: `${gender}_${category}_surprise`,
                                    title: 'Surprise Me!',
                                    img: 'headshot-photo/images/surprise.png',
                                    isSurprise: true
                                });
                            }
                            
                            // Update the list
                            if (loadedItems.length > 0) {
                                currentClothingList = loadedItems;
                            }
                            
                            // Re-render if this is the current selection
                            if (currentGender === gender && currentCategory === category) {
                                currentIndex = 0;
                                renderGallery();
                                document.getElementById('clothingGallery').style.display = 'flex';
                                hideGalleryLoader();
                                disableAllButtons(false);
                            }
                        }
                        // Image doesn't exist, skip it silently
                    };
                    // Suppress error reporting for images
                    img.crossOrigin = "anonymous";
                    img.src = imgPath;
                }
            } catch (error) {
                console.log('Loading images from folder:', error);
                hideGalleryLoader();
                disableAllButtons(false);
            }
        }

        // Show loader in gallery
        function showGalleryLoader() {
            const loader = document.getElementById('galleryLoader');
            const image = document.getElementById('galleryImage');
            const title = document.getElementById('galleryTitle');
            const hint = document.getElementById('selectHint');
            if (loader) loader.style.display = 'block';
            if (image) image.style.display = 'none';
            if (title) title.innerHTML = '';
            if (hint) hint.style.display = 'none';
        }

        // Hide loader in gallery
        function hideGalleryLoader() {
            const loader = document.getElementById('galleryLoader');
            if (loader) loader.style.display = 'none';
            const hint = document.getElementById('selectHint');
            if (hint) hint.style.display = 'block';
        }

        // Disable/enable all tab and gender buttons
        function disableAllButtons(disabled) {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.disabled = disabled;
                btn.style.opacity = disabled ? '0.5' : '1';
                btn.style.cursor = disabled ? 'not-allowed' : 'pointer';
            });
            document.getElementById('genderMale').disabled = disabled;
            document.getElementById('genderFemale').disabled = disabled;
            document.getElementById('genderMale').style.opacity = disabled ? '0.5' : '1';
            document.getElementById('genderFemale').style.opacity = disabled ? '0.5' : '1';
            document.getElementById('genderMale').style.cursor = disabled ? 'not-allowed' : 'pointer';
            document.getElementById('genderFemale').style.cursor = disabled ? 'not-allowed' : 'pointer';
        }

        function renderGallery() {
            const list = currentClothingList;
            if (list.length === 0) {
                galleryImage.src = '';
                galleryTitle.innerText = 'No images found. Add PNG files to: headshot-photo/images/' + currentGender + '/' + currentCategory + '/';
                clothingChoice.value = '';
                clothingStyleHidden.value = currentCategory;
                return;
            }
            if (currentIndex < 0) currentIndex = 0;
            if (currentIndex >= list.length) currentIndex = list.length - 1;
            const item = list[currentIndex];
            
            // Handle surprise item in the list
            if (item.isSurprise) {
                // Show just a question mark instead of image
                galleryImage.style.display = 'none';
                galleryImage.src = '';
                galleryTitle.innerHTML = '<div style="font-size:80px; font-weight:bold; color:#4f46e5; margin:0;">?</div><div style="margin-top:10px;">Surprise Me!</div>';
                clothingChoice.value = item.id;
                clothingStyleHidden.value = currentCategory;
                document.getElementById('clothingFilename').value = 'SURPRISE_MODE';
                
                const desc = styleDescriptions[currentCategory];
                if (desc) {
                    styleDescription.innerHTML = `<strong>For Men:</strong> ${desc.men}<br><strong>For Women:</strong> ${desc.women}`;
                }
                // reflect persistent selection if this item is selected
                const viewport = document.getElementById('galleryViewport');
                if (persistSelectedIndex === currentIndex) {
                    viewport.classList.add('selected');
                } else {
                    viewport.classList.remove('selected');
                }
                return;
            }
            
            // Handle 'same' (keep clothes) special item
            if (item.isSame) {
                galleryImage.style.display = 'none';
                galleryImage.src = '';
                galleryTitle.innerHTML = '<div style="font-size:18px; font-weight:700; color:#34d399; margin:0;">Use the Clothes I am Wearing</div>';
                clothingChoice.value = item.id;
                clothingStyleHidden.value = currentCategory;
                document.getElementById('clothingFilename').value = 'SAME_CLOTHES';

                const descSame = styleDescriptions[currentCategory];
                if (descSame) {
                    styleDescription.innerHTML = `<strong>For Men:</strong> ${descSame.men}<br><strong>For Women:</strong> ${descSame.women}`;
                }

                const viewport = document.getElementById('galleryViewport');
                if (persistSelectedIndex === currentIndex) {
                    viewport.classList.add('selected');
                } else {
                    viewport.classList.remove('selected');
                }
                return;
            }
            
            galleryImage.style.display = 'block';
            galleryImage.src = item.img;
            galleryTitle.innerText = item.title;
            clothingChoice.value = item.id;
            clothingStyleHidden.value = currentCategory;
            // reflect persistent selection visually
            const viewport = document.getElementById('galleryViewport');
            if (persistSelectedIndex === currentIndex) {
                viewport.classList.add('selected');
            } else {
                viewport.classList.remove('selected');
            }
            // set filename for server to pick up exact clothing image
            const parts = item.img.split('/');
            const fname = parts[parts.length - 1];
            document.getElementById('clothingFilename').value = fname;

            // Update description guide for category
            const desc = styleDescriptions[currentCategory];
            if (desc) {
                styleDescription.innerHTML = `<strong>For Men:</strong> ${desc.men}<br><strong>For Women:</strong> ${desc.women}`;
            }
        }

        // Tab click
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all tabs
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                // Add active class to clicked tab
                this.classList.add('active');
                
                currentCategory = this.getAttribute('data-category');
                currentIndex = 0;
                // Clear any persisted selection when changing category
                persistSelectedIndex = null;
                const viewport = document.getElementById('galleryViewport');
                if (viewport) viewport.classList.remove('selected');
                loadClothingOptions(currentGender, currentCategory);
            });
        });

        // Gender buttons
        document.getElementById('genderMale').addEventListener('click', function() {
            // Remove active from both
            document.getElementById('genderMale').classList.remove('active');
            document.getElementById('genderFemale').classList.remove('active');
            // Add active to clicked
            this.classList.add('active');
            
            currentGender = 'male';
            clothingGender.value = 'male';
            currentIndex = 0;
            // Clear any persisted selection when changing gender
            persistSelectedIndex = null;
            const viewport = document.getElementById('galleryViewport');
            if (viewport) viewport.classList.remove('selected');

            // Enable category buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
            });

            // Only load if a category has been selected
            if (currentCategory) {
                loadClothingOptions(currentGender, currentCategory);
            }
        });
        document.getElementById('genderFemale').addEventListener('click', function() {
            // Remove active from both
            document.getElementById('genderMale').classList.remove('active');
            document.getElementById('genderFemale').classList.remove('active');
            // Add active to clicked
            this.classList.add('active');
            
            currentGender = 'female';
            clothingGender.value = 'female';
            currentIndex = 0;
            // Clear any persisted selection when changing gender
            persistSelectedIndex = null;
            const viewport = document.getElementById('galleryViewport');
            if (viewport) viewport.classList.remove('selected');

            // Enable category buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
            });

            // Only load if a category has been selected
            if (currentCategory) {
                loadClothingOptions(currentGender, currentCategory);
            }
        });

        prevItem.addEventListener('click', function() {
            currentIndex = Math.max(0, currentIndex - 1);
            renderGallery();
        });
        nextItem.addEventListener('click', function() {
            currentIndex = Math.min(currentClothingList.length - 1, currentIndex + 1);
            renderGallery();
        });

        // Function to select the current item (for mobile)
        function selectCurrentItem() {
            // Toggle persistent selection for the currently shown item
            const galleryViewport = document.getElementById('galleryViewport');
            if (persistSelectedIndex === currentIndex) {
                // Deselect
                persistSelectedIndex = null;
                galleryViewport.classList.remove('selected');
            } else {
                // Select current
                persistSelectedIndex = currentIndex;
                galleryViewport.classList.add('selected');
            }
        }

        // Initialize - No default category selected, user must choose
        // document.getElementById('genderMale').classList.add('active');

        // Disable category buttons by default
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.disabled = true;
            btn.style.opacity = '0.5';
            btn.style.cursor = 'not-allowed';
        });

        currentCategory = null;
        currentClothingList = [];

        // Image Preview - Handle both uploaded files and webcam captures
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Check if it's an image
                if (!file.type.startsWith('image/')) {
                    showError("Please select a valid image file.");
                    return;
                }
                
                // Check if this is a webcam capture (already has correct orientation, no EXIF fix needed)
                const isWebcamCapture = file.name === "webcam_capture.jpg" || file.name === "webcam_capture.png";
                
                if (isWebcamCapture) {
                    // For webcam captures, show directly without EXIF processing
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        document.querySelector('.upload-icon').style.display = 'none';
                        document.querySelector('.upload-area h3').style.display = 'none';
                        document.querySelector('.upload-area p').style.display = 'none';
                        
                        // Validate the image
                        validateImage(file);
                    };
                    reader.readAsDataURL(file);
                } else {
                    // For uploaded files, fix EXIF orientation if needed
                    if (typeof EXIF !== 'undefined') {
                        fixImageOrientation(file, function(dataUrl) {
                            preview.src = dataUrl;
                            preview.style.display = 'block';
                            document.querySelector('.upload-icon').style.display = 'none';
                            document.querySelector('.upload-area h3').style.display = 'none';
                            document.querySelector('.upload-area p').style.display = 'none';
                            
                            // Validate the image
                            validateImage(file);
                        });
                    } else {
                        // Fallback if EXIF library not loaded
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                            document.querySelector('.upload-icon').style.display = 'none';
                            document.querySelector('.upload-area h3').style.display = 'none';
                            document.querySelector('.upload-area p').style.display = 'none';
                            
                            // Validate the image
                            validateImage(file);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }
        });

        // Camera Logic
        startCameraBtn.addEventListener('click', async () => {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
                cameraContainer.style.display = 'flex';
                dropZone.style.display = 'none';
                startCameraBtn.style.display = 'none';
                
                // Start detection loop
                startFaceDetection();
            } catch (err) {
                showError("Could not access camera: " + err.message);
            }
        });

        function startFaceDetection() {
            if (trackerTask) {
                trackerTask.stop();
            }

            tracker = new tracking.ObjectTracker('face');
            tracker.setInitialScale(4);
            tracker.setStepSize(2);
            tracker.setEdgesDensity(0.1);
            
            // Sync overlay canvas size
            overlayCanvas.width = video.videoWidth;
            overlayCanvas.height = video.videoHeight;

            faceStatus.innerText = "Looking for face...";
            faceStatus.className = "face-status";
            captureBtn.disabled = true;

            // Stabilization variables to reduce flickering messages
            let lastStatus = '';
            let lastStatusType = '';
            let stableFrameCount = 0;
            let noFaceFrameCount = 0;
            const STABLE_THRESHOLD = 5; // Frames needed to confirm status change
            const NO_FACE_THRESHOLD = 10; // Frames before showing "no face" error

            tracker.on('track', function(event) {
                overlayCtx.clearRect(0, 0, overlayCanvas.width, overlayCanvas.height);
                
                if (event.data.length === 0) {
                    noFaceFrameCount++;
                    // Only show "no face" after several consecutive frames without detection
                    if (noFaceFrameCount > NO_FACE_THRESHOLD) {
                        if (lastStatus !== 'no_face') {
                            updateStatus("No face detected. Please look at the camera.", "error");
                            lastStatus = 'no_face';
                            lastStatusType = 'error';
                        }
                        captureBtn.disabled = true;
                    }
                    stableFrameCount = 0;
                    return;
                }
                
                // Face detected - reset no face counter
                noFaceFrameCount = 0;
                
                const face = event.data[0];
                const vidWidth = video.videoWidth;
                const vidHeight = video.videoHeight;

                // Validation Parameters (relaxed thresholds)
                const margin = 15; // Reduced margin for more tolerance
                const minWidth = vidWidth * 0.12; // Reduced minimum face size requirement
                const centerTolerance = vidWidth * 0.30; // Increased center tolerance
                
                let currentStatus = 'perfect';
                let statusMsg = "Perfect! Hold still.";
                let statusType = 'success';
                let boxColor = '#34d399';
                
                // Check 1: Edges (relaxed check)
                if (face.x < margin || face.y < margin || (face.x + face.width) > (vidWidth - margin)) {
                    currentStatus = 'edge';
                    statusMsg = "Move slightly away from edge";
                    statusType = 'warning';
                    boxColor = '#fbbf24';
                }
                // Check 2: Size (too small/far)
                else if (face.width < minWidth) {
                    currentStatus = 'far';
                    statusMsg = "Move a bit closer";
                    statusType = 'warning';
                    boxColor = '#fbbf24';
                }
                // Check 3: Centering (relaxed)
                else {
                    const faceCenter = face.x + (face.width / 2);
                    const screenCenter = vidWidth / 2;
                    if (Math.abs(faceCenter - screenCenter) > centerTolerance) {
                        currentStatus = 'center';
                        statusMsg = "Center your face a bit more";
                        statusType = 'warning';
                        boxColor = '#fbbf24';
                    }
                }
                
                // Draw bounding box
                overlayCtx.strokeStyle = boxColor;
                overlayCtx.lineWidth = 4;
                overlayCtx.strokeRect(face.x, face.y, face.width, face.height);
                
                // Stabilization: only update status after consistent detection
                if (currentStatus === lastStatus) {
                    stableFrameCount++;
                } else {
                    stableFrameCount = 1;
                }
                
                // For "perfect" status, enable capture immediately but wait for stable message
                if (currentStatus === 'perfect') {
                    captureBtn.disabled = false;
                    if (stableFrameCount >= 2 && (lastStatusType !== 'success')) {
                        updateStatus(statusMsg, statusType);
                        lastStatusType = statusType;
                    }
                } else {
                    // For warnings, only show after several stable frames to avoid flickering
                    if (stableFrameCount >= STABLE_THRESHOLD && lastStatus !== currentStatus) {
                        updateStatus(statusMsg, statusType);
                        lastStatusType = statusType;
                    }
                    captureBtn.disabled = true;
                }
                
                lastStatus = currentStatus;
            });

            trackerTask = tracking.track('#video', tracker);
        }

        function updateStatus(msg, type) {
            faceStatus.innerText = msg;
            faceStatus.className = "face-status " + type;
        }

        captureBtn.addEventListener('click', () => {
            // Get video dimensions
            const vidWidth = video.videoWidth;
            const vidHeight = video.videoHeight;
            
            // Set canvas to match video dimensions
            canvas.width = vidWidth;
            canvas.height = vidHeight;
            const ctx = canvas.getContext('2d');
            
            // Mirror the image to match what user sees in preview (scaleX(-1))
            ctx.save();
            ctx.scale(-1, 1);
            ctx.drawImage(video, -vidWidth, 0, vidWidth, vidHeight);
            ctx.restore();
            
            // Convert to blob and set preview
            canvas.toBlob(blob => {
                // Create a file without EXIF orientation to prevent rotation
                const file = new File([blob], "webcam_capture.jpg", { 
                    type: "image/jpeg",
                    lastModified: Date.now()
                });
                
                // Create a DataTransfer to update the file input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                imageInput.files = dataTransfer.files;

                // Show preview immediately without EXIF processing (since we already fixed orientation)
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    document.querySelector('.upload-icon').style.display = 'none';
                    document.querySelector('.upload-area h3').style.display = 'none';
                    document.querySelector('.upload-area p').style.display = 'none';
                };
                reader.readAsDataURL(file);

                stopCamera();
            }, 'image/jpeg', 0.95);
        });

        closeCameraBtn.addEventListener('click', stopCamera);

        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            if (trackerTask) {
                trackerTask.stop();
                trackerTask = null;
            }
            cameraContainer.style.display = 'none';
            dropZone.style.display = 'block';
            startCameraBtn.style.display = 'block';
        }

        // Form Submission
        uploadForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!imageInput.files[0]) {
                showError("Please select an image first.");
                return;
            }

            // Reset UI
            showError("");
            generateBtn.disabled = true;
            loadingOverlay.style.display = 'flex';
            generatedImage.style.display = 'none';
            placeholderText.style.display = 'none';
            downloadLink.style.display = 'none';
            
            let clothingFilename = document.getElementById('clothingFilename').value;
            let clothingStyle = document.getElementById('clothingStyle').value;
            let surpriseMode = false;
            
            // Check if surprise mode is selected
            if (clothingFilename === 'SURPRISE_MODE') {
                surpriseMode = true;
                // Don't pick random here, let backend handle it
                clothingFilename = '';
            }
            
            const formData = new FormData();
            formData.append('image', imageInput.files[0]);
            formData.append('clothingStyle', clothingStyle);
            formData.append('clothingGender', document.getElementById('clothingGender').value);
            formData.append('clothingFilename', clothingFilename);
            formData.append('surpriseMode', surpriseMode ? '1' : '0');

            try {
                statusText.innerText = "Analyzing facial features...";
                
                // Switch between process.php (Gemini + Stability AI) or process_gemini_only.php (Gemini only)
                // Change this to 'process_gemini_only.php' to use only Gemini
                const processFile = './headshot-photo/process.php'; // or 'process_gemini_only.php' for Gemini-only
                
                const response = await fetch(processFile, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    statusText.innerText = "Rendering corporate headshot...";
                    // Simulate a slight delay for the second step if needed, or just show result
                    
                    generatedImage.src = data.image_url; // Assuming process.php returns base64 or url
                    generatedImage.style.display = 'block';
                    loadingOverlay.style.display = 'none';
                    
                    downloadLink.href = data.image_url;
                    downloadLink.download = 'corporate_headshot.png';
                    downloadLink.style.display = 'block';
                } else {
                    throw new Error(data.error || "Unknown error occurred");
                }

            } catch (error) {
                console.error(error);
                // Better error messaging
                if (error.message && error.message.includes('Rate Limit')) {
                    showError('API service is busy. Please wait a moment and try again.');
                } else {
                    showError(error.message);
                }
                loadingOverlay.style.display = 'none';
                placeholderText.style.display = 'block';
            } finally {
                generateBtn.disabled = false;
            }
        });

        function showError(msg) {
            errorMessage.innerText = msg;
            errorMessage.style.display = msg ? 'block' : 'none';
        }
    </script>

<?php include 'footer.php'; ?>