@extends('crm.layout')

@section('title', 'Email Details')

@section('content')
<style>
    :root {
        --primary-color: #4f46e5; /* Indigo 600 */
        --primary-light: #eef2ff;
        --secondary-color: #64748b;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --bg-color: #f8fafc;
        --card-bg: #ffffff;
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    body { font-family: 'Inter', system-ui, -apple-system, sans-serif; background-color: var(--bg-color); }

    .back-nav { margin-bottom: 1.5rem; }
    .btn-back { display: inline-flex; align-items: center; background: white; border: 1px solid var(--border-color); color: var(--secondary-color); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 500; text-decoration: none; transition: all 0.2s; box-shadow: var(--shadow-sm); }
    .btn-back:hover { color: #1e293b; border-color: #cbd5e1; }

    .main-container {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 2rem;
        align-items: start;
    }

    /* Cards */
    .crm-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: box-shadow 0.2s;
    }
    .crm-card:hover { box-shadow: var(--shadow-md); }

    .card-header-title {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 0.75rem;
    }

    /* Info Items */
    .info-item { margin-bottom: 1.25rem; }
    .info-item:last-child { margin-bottom: 0; }
    .label { font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 0.35rem; display: block; }
    .value { font-size: 0.95rem; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 0.5rem; word-break: break-word;}
    .value a { color: var(--primary-color); text-decoration: none; }
    .value a:hover { text-decoration: underline; }
    
    .icon-box {
        width: 28px; height: 28px;
        background: #f1f5f9;
        color: #64748b;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem;
    }

    /* Header Section */
    .email-header {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        margin-bottom: 2rem;
        display: flex;
        flex-direction: column;
    }
    .email-subject { font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2; }
    .email-meta { display: flex; align-items: center; gap: 1rem; margin-top: 0.5rem; color: #64748b; font-size: 0.9rem; }
    
    .status-badge {
        padding: 0.35rem 0.85rem;
        border-radius: 99px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .badge-verified { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
    .badge-spam { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    /* Message Content */
    .message-container {
        position: relative;
    }
    .product-highlight {
        background: linear-gradient(to right, #eef2ff, #fff);
        border-left: 4px solid var(--primary-color);
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    .product-highlight-label { font-size: 0.75rem; font-weight: 600; color: #6366f1; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem; }
    .product-highlight-value { font-size: 1.25rem; font-weight: 800; color: #1e1b4b; }

    .message-body {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        font-size: 1rem;
        line-height: 1.7;
        color: #334155;
        white-space: pre-line;
    }

    /* Action Buttons */
    .actions-group { display: flex; gap: 0.75rem; }
    .btn-action { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.2rem; border-radius: 10px; font-weight: 600; font-size: 0.85rem; border: none; cursor: pointer; transition: all 0.2s; }
    .btn-no-spam { background: #dcfce7; color: #166534; } .btn-no-spam:hover { background: #bbf7d0; }
    .btn-spam { background: #fee2e2; color: #ef4444; } .btn-spam:hover { background: #fecaca; }
    .btn-delete { background: #ef4444; color: white; padding: 0.6rem; } .btn-delete:hover { background: #dc2626; }

    /* Attachment */
    .attachment-section { margin-top: 2rem; }
    .attachment-preview {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        transition: all 0.2s;
    }
    .attachment-preview:hover { border-color: var(--primary-color); background: #f1f5f9; }
    .attachment-preview img { max-width: 100%; max-height: 500px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); cursor: zoom-in; }

    @media (max-width: 1024px) {
        .main-container { grid-template-columns: 1fr; }
        .email-header > div:first-child { flex-direction: column; align-items: flex-start; gap: 1rem; }
        .actions-group { width: 100%; justify-content: flex-start; flex-wrap: wrap; }
    }
</style>

<div class="back-nav">
    <a href="{{ route('crm.emails.index') }}" class="btn-back">
        <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Back to Inbox
    </a>
</div>

<!-- Header Card -->
<div class="email-header">
    <!-- Row 1: Subject and Action Buttons -->
    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 1rem;">
        <h1 class="email-subject">{{ $email->subject ?: 'General Inquiry' }}</h1>
        <div class="actions-group">
            @if($email->is_spam)
                <form action="{{ route('crm.emails.markValid', $email->id) }}" method="POST">
                    {{ csrf_field() }}
                    <button type="submit" class="btn-action btn-no-spam"><i class="fas fa-inbox"></i> Move to Inbox</button>
                </form>
            @else
                <form action="{{ route('crm.emails.markSpam', $email->id) }}" method="POST">
                    {{ csrf_field() }}
                    <button type="submit" class="btn-action btn-spam"><i class="fas fa-ban"></i> Mark as Spam</button>
                </form>
            @endif

            <button type="button" class="btn-action btn-forward" onclick="openForwardModal()" style="background: #3b82f6; color: white; margin-right: 0.5rem;"><i class="fas fa-share"></i> Forward</button>

            @if(Auth::guard('crm')->user()->isAdmin())
            <form action="{{ route('crm.emails.destroy', $email->id) }}" method="POST" onsubmit="return confirm('Delete this inquiry?');">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn-action btn-delete" title="Delete"><i class="fas fa-trash-alt"></i></button>
            </form>
            @endif
        </div>
    </div>

    <!-- Row 2: Date, Time, and Warning -->
    <div class="email-meta">
        <span><i class="far fa-calendar-alt"></i> {{ $email->created_at->format('F d, Y') }}</span>
        <span><i class="far fa-clock"></i> {{ $email->created_at->format('h:i A') }}</span>
        @if($email->is_spam)
            <span class="status-badge badge-spam">Possibly Spam ({{ $email->spam_reason }})</span>
        @else
            <span class="status-badge badge-verified"><i class="fas fa-shield-check"></i> Verified Inquiry</span>
        @endif
    </div>
</div>

<!-- Forward Modal -->
<div id="forwardModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: white; width: 100%; max-width: 500px; border-radius: 16px; padding: 2rem; box-shadow: 0 10px 25px rgba(0,0,0,0.2); animation: slideIn 0.3s ease;">
        <h3 style="margin-top: 0; margin-bottom: 0.5rem; font-size: 1.25rem;">Forward Inquiry</h3>
        <p style="color: #64748b; margin-top: 0; margin-bottom: 1.5rem; font-size: 0.95rem;">Enter the email address to forward this inquiry details.</p>
        
        <form action="{{ route('crm.emails.forward', $email->id) }}" method="POST">
            {{ csrf_field() }}
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.5rem; color: #334155;">Recipient Email</label>
                <div style="position: relative;">
                    <i class="fas fa-envelope" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                    <input type="email" name="forward_email" required placeholder="recipient@example.com" style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 1rem; outline: none; transition: border 0.2s;" onfocus="this.style.borderColor = '#3b82f6'" onblur="this.style.borderColor = '#cbd5e1'">
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <button type="button" onclick="closeForwardModal()" style="padding: 0.6rem 1.2rem; background: white; border: 1px solid #cbd5e1; border-radius: 8px; color: #64748b; font-weight: 600; cursor: pointer;">Cancel</button>
                <button type="submit" style="padding: 0.6rem 1.5rem; background: #3b82f6; border: none; border-radius: 8px; color: white; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                    Send <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openForwardModal() {
        document.getElementById('forwardModal').style.display = 'flex';
    }
    function closeForwardModal() {
        document.getElementById('forwardModal').style.display = 'none';
    }
    // Close modal on outside click
    document.getElementById('forwardModal').addEventListener('click', function(e) {
        if(e.target === this) closeForwardModal();
    });
</script>

<style>
    @keyframes slideIn {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>

<div class="main-container">
    
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Client Info -->
        <div class="crm-card">
            <div class="card-header-title"><i class="fas fa-user-circle"></i> Client Information</div>
            
            <div class="info-item">
                <span class="label">Name</span>
                <div class="value">
                    <div class="icon-box"><i class="fas fa-user"></i></div>
                    {{ $email->client_name }}
                </div>
            </div>
            
            <div class="info-item">
                <span class="label">Email</span>
                <div class="value">
                    <div class="icon-box"><i class="fas fa-envelope"></i></div>
                    <a href="mailto:{{ $email->client_email }}">{{ $email->client_email }}</a>
                </div>
            </div>
            
            <div class="info-item">
                <span class="label">Phone</span>
                <div class="value">
                    <div class="icon-box"><i class="fas fa-phone"></i></div>
                    {{ $email->client_phone ?: 'Not Provided' }}
                </div>
            </div>
            
            <div class="info-item">
                 <span class="label">IP Address</span>
                 <div class="value" style="font-size: 0.85rem; color: #000000ff;">
                    @php
                        $cName = $email->country ?: 'Unknown';
                        $cMap = [
                            'Australia' => ['au', 'AUS'], 'India' => ['in', 'IND'], 'United States' => ['us', 'USA'],
                            'United Kingdom' => ['gb', 'GBR'], 'Canada' => ['ca', 'CAN'], 'New Zealand' => ['nz', 'NZL'],
                            'China' => ['cn', 'CHN'], 'Japan' => ['jp', 'JPN'], 'Germany' => ['de', 'DEU'],
                            'France' => ['fr', 'FRA'], 'Italy' => ['it', 'ITA'], 'Spain' => ['es', 'ESP'],
                            'Brazil' => ['br', 'BRA'], 'Mexico' => ['mx', 'MEX'], 'Russia' => ['ru', 'RUS'],
                            'South Africa' => ['za', 'ZAF'], 'Singapore' => ['sg', 'SGP'], 'Malaysia' => ['my', 'MYS'],
                            'Philippines' => ['ph', 'PHL'], 'Indonesia' => ['id', 'IDN'], 'Thailand' => ['th', 'THA'],
                            'Vietnam' => ['vn', 'VNM'], 'Pakistan' => ['pk', 'PAK'], 'Bangladesh' => ['bd', 'BGD'],
                            'Sri Lanka' => ['lk', 'LKA'], 'Nepal' => ['np', 'NPL'], 'Saudi Arabia' => ['sa', 'SAU'],
                            'United Arab Emirates' => ['ae', 'ARE'], 'Netherlands' => ['nl', 'NLD'], 'Sweden' => ['se', 'SWE'],
                            'Norway' => ['no', 'NOR'], 'Denmark' => ['dk', 'DNK'], 'Finland' => ['fi', 'FIN'],
                            'Poland' => ['pl', 'POL'], 'Turkey' => ['tr', 'TUR'], 'Israel' => ['il', 'ISR'],
                            'Egypt' => ['eg', 'EGY'], 'South Korea' => ['kr', 'KOR'], 'Taiwan' => ['tw', 'TWN'],
                            'Hong Kong' => ['hk', 'HKG'], 'Argentina' => ['ar', 'ARG'], 'Chile' => ['cl', 'CHL'],
                            'Colombia' => ['co', 'COL'], 'Peru' => ['pe', 'PER'], 'Ireland' => ['ie', 'IRL'],
                            'Switzerland' => ['ch', 'CHE'], 'Austria' => ['at', 'AUT'], 'Belgium' => ['be', 'BEL']
                        ];
                        $cCode = $cMap[$cName][0] ?? null;
                        $cIso = $cMap[$cName][1] ?? strtoupper(substr($cName, 0, 3));
                    @endphp

                     @if($cCode)
                        <img src="https://flagcdn.com/w40/{{ $cCode }}.png" 
                             srcset="https://flagcdn.com/w80/{{ $cCode }}.png 2x" 
                             alt="{{ $cName }}" 
                             style="width: 24px; height: auto; border-radius: 3px; margin-right: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                     @else
                        <div style="margin-right:8px; color: #64748b" class="icon-box"><i class="fas fa-globe"></i></div>
                     @endif
                     
                     <span style="font-weight: 600; color: #1e293b;">{{ $email->ip_address }}</span>
                     <span style="color: #64748b; font-weight: 500; margin-left: 4px;">({{ $cIso }})</span>
                 </div>
            </div>
        </div>

        <!-- Product Specs -->
        <div class="crm-card">
            <div class="card-header-title"><i class="fas fa-box-open"></i> Product Specs</div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="info-item">
                    <span class="label">Quantity</span>
                    <div class="value" style="font-size: 1.1rem;">{{ $email->quantity ?: '-' }}</div>
                </div>
                <div class="info-item">
                    <span class="label">Unit</span>
                    <div class="value">{{ $email->unit ?: '-' }}</div>
                </div>
            </div>
            
            <div class="info-item">
                <span class="label">Dimensions (L x W x H)</span>
                <div class="value"><i class="fas fa-ruler-combined" style="color:#94a3b8; margin-right:5px;"></i> {{ $email->length }} x {{ $email->width }} x {{ $email->height }}</div>
            </div>

            <div class="info-item">
                <span class="value" class="label">Stock Material</span>
                <div style="color: #64748b;margin-top:5px;"  >{{ $email->stock ?: 'Standard' }}</div>
            </div>

            <div class="info-item" >
                <span class="value" style="font-size: 1.1rem;margin-top:5px;" class="label">Color & Coating</span>
                <div style="gap: 0; margin-top:5px;color: #64748b">
                    <div>{{ $email->color ?: 'No Color Info' }}</div>
                    <div style="font-size: 0.8rem; color: #64748b;margin-top:5px;">{{ $email->coating ?: 'No Coating Info' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="message-container">
        
        <div class="product-highlight">
            <div class="product-highlight-label">Product of Interest</div>
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                <div>
                    <div class="product-highlight-value">{{ $email->product_name ?: 'General Inquiry' }}</div>
                    @if(isset($productDetails) && $productDetails->prod_url)
                       <a href="{{ url($productDetails->prod_url) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.85rem; margin-top: 6px; color: var(--primary-color); font-weight: 500; text-decoration: none;">
                          View Product <i class="fas fa-external-link-alt" style="font-size: 0.75rem;"></i>
                       </a>
                   @endif
                </div>
                
                @if(isset($productDetails) && $productDetails->prod_image)
                    <img src="{{ asset('images/'.$productDetails->prod_image) }}" alt="Product Image" style="height: 80px; width: 80px; border-radius: 8px; border: 1px solid #e2e8f0; object-fit: cover;">
                @endif
            </div>
        </div>

        <div class="crm-card" style="padding: 0;">
            <div style="padding: 1rem 1.5rem; background: #f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 16px 16px 0 0; font-weight: 700; color: #475569;">
                <i class="fas fa-align-left" style="margin-right: 8px;"></i> Message Content
            </div>
            <div class="message-body" style="border: none; border-radius: 0 0 16px 16px;">
                {{ $email->message }}
            </div>
        </div>

        @if($email->file_url)
            @php
                $ext = pathinfo($email->file_url, PATHINFO_EXTENSION);
                $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            @endphp

            <div class="attachment-section">
                <div class="card-header-title" style="border-bottom: none;"><i class="fas fa-paperclip"></i> Attachment</div>
                
                @if($isImage)
                    <div class="attachment-preview">
                        <img src="{{ $email->file_url }}" alt="Attachment" onclick="window.open(this.src, '_blank')">
                        <div style="margin-top: 10px; font-size: 0.8rem; color: #64748b; font-weight: 500;">
                            <i class="fas fa-search-plus"></i> Click image to view full size
                        </div>
                    </div>
                @endif
                
                <div style="margin-top: 1rem; background: white; border: 1px solid #e2e8f0; padding: 1rem; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; box-shadow: var(--shadow-sm);">
                     <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 42px; height: 42px; background: #e0f2fe; color: #0284c7; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-download" style="font-size: 1.2rem;"></i>
                        </div>
                        <div style="font-size: 0.9rem; font-weight: 600; color: #1e293b; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">
                            {{ basename($email->file_url) }}
                        </div>
                     </div>
                     <a href="{{ $email->file_url }}" target="_blank" class="btn-action" style="background:var(--primary-color); color:white;">
                        Download <i class="fas fa-arrow-down"></i>
                     </a>
                </div>
            </div>
        @endif

    </div>

</div>
@endsection
