<?php
// views/lienhe.php
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/layout/menu.php';
?>

<style>
.contact-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0;
    color: white;
    margin-bottom: 60px;
}

.contact-card {
    border: none;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border-radius: 20px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.contact-card:hover {
    transform: translateY(-5px);
}

.contact-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    padding: 40px;
    text-align: center;
    color: white;
}

.contact-form {
    padding: 40px;
}

.form-control-custom {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 15px 20px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.form-control-custom:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    background: white;
}

.btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 15px;
    padding: 15px 40px;
    font-size: 18px;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

.btn-submit:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-submit:hover:before {
    left: 100%;
}

.contact-info {
    background: #f8f9fa;
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 40px;
}

.contact-info-item {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
    padding: 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.contact-info-item:hover {
    transform: translateX(10px);
}

.contact-info-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    color: white;
    font-size: 24px;
}

.alert-custom {
    border: none;
    border-radius: 15px;
    padding: 20px;
    margin-top: 20px;
    font-weight: 500;
}

.alert-success-custom {
    background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
    color: white;
}

.alert-error-custom {
    background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
    color: white;
}

.floating-label {
    position: relative;
    margin-bottom: 25px;
}

.floating-label label {
    position: absolute;
    top: 50%;
    left: 20px;
    transform: translateY(-50%);
    color: #666;
    font-size: 16px;
    pointer-events: none;
    transition: all 0.3s ease;
    background: transparent;
    padding: 0 5px;
}

.floating-label input:focus + label,
.floating-label input:not(:placeholder-shown) + label,
.floating-label textarea:focus + label,
.floating-label textarea:not(:placeholder-shown) + label,
.floating-label select:focus + label,
.floating-label select:not([value=""]) + label {
    top: 0;
    font-size: 14px;
    color: #667eea;
    background: white;
    font-weight: 500;
}

.floating-label textarea + label {
    top: 25px;
}

.floating-label textarea:focus + label,
.floating-label textarea:not(:placeholder-shown) + label {
    top: 0;
}

@media (max-width: 768px) {
    .contact-hero {
        padding: 60px 0;
    }
    
    .contact-header,
    .contact-form,
    .contact-info {
        padding: 30px 20px;
    }
    
    .contact-info-item {
        flex-direction: column;
        text-align: center;
    }
    
    .contact-info-icon {
        margin-right: 0;
        margin-bottom: 15px;
    }
}

.check-reply-section {
    background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
    padding: 30px;
    border-radius: 20px;
    border: 2px solid #667eea30;
    margin-top: 30px;
    position: relative;
}

.check-reply-section::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #f5576c);
    border-radius: 22px;
    z-index: -1;
    animation: borderGlow 3s ease-in-out infinite alternate;
}

@keyframes borderGlow {
    0% { opacity: 0.5; }
    100% { opacity: 1; }
}

.reply-results-section {
    margin-top: 40px;
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.reply-item {
    border: none;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s ease;
    margin-bottom: 30px;
    position: relative;
}

.reply-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.reply-item .card-header {
    border: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    position: relative;
    overflow: hidden;
}

.reply-item .card-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.reply-item:hover .card-header::before {
    left: 100%;
}

.status-badge {
    font-size: 12px;
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-pending {
    background: linear-gradient(135deg, #ffc107, #ff8f00);
    color: white;
}

.status-read {
    background: linear-gradient(135deg, #17a2b8, #007bff);
    color: white;
}

.status-replied {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.status-closed {
    background: linear-gradient(135deg, #6c757d, #495057);
    color: white;
}

.customer-message {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-left: 4px solid #6c757d;
    padding: 25px;
    border-radius: 15px;
    margin-bottom: 20px;
    position: relative;
}

.customer-message::before {
    content: '\f007';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    top: 10px;
    right: 15px;
    color: #6c757d;
    font-size: 18px;
}

.admin-reply {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    border-left: 4px solid #17a2b8;
    padding: 25px;
    border-radius: 15px;
    position: relative;
}

.admin-reply::before {
    content: '\f4ad';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    top: 10px;
    right: 15px;
    color: #17a2b8;
    font-size: 18px;
}

.no-reply-message {
    text-align: center;
    padding: 40px;
    color: #6c757d;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    border: 2px dashed #dee2e6;
}

.contact-timeline {
    position: relative;
    padding-left: 30px;
}

.contact-timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #667eea, #764ba2);
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -22px;
    top: 10px;
    width: 12px;
    height: 12px;
    background: #667eea;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 3px #667eea;
}

.search-form {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.search-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

@media (max-width: 768px) {
    .check-reply-section {
        padding: 20px;
        margin-top: 20px;
    }
    
    .reply-item .card-header .row {
        text-align: center;
    }
    
    .reply-item .card-header .col-md-4 {
        margin-top: 15px;
    }
    
    .customer-message,
    .admin-reply {
        padding: 20px;
        margin-bottom: 15px;
    }
    
    .contact-timeline {
        padding-left: 20px;
    }
    
    .timeline-item::before {
        left: -17px;
    }
    
    .reply-item .card-body .row {
        flex-direction: column;
    }
    
    .reply-item .card-body .col-lg-6 {
        margin-bottom: 20px;
    }
    
    .status-badge {
        font-size: 11px;
        padding: 6px 12px;
    }
    
    .empty-state {
        padding: 40px 15px;
    }
    
    .empty-state i {
        font-size: 3rem;
    }
    
    .search-form {
        padding: 20px;
    }
    
    .floating-label input,
    .floating-label textarea,
    .floating-label select {
        font-size: 16px; /* Prevent zoom on iOS */
    }
}

@media (max-width: 576px) {
    .contact-hero h1 {
        font-size: 2rem;
    }
    
    .contact-hero p {
        font-size: 1rem;
    }
    
    .reply-item .card-header h5 {
        font-size: 1.1rem;
    }
    
    .timeline-item {
        margin-bottom: 20px;
    }
    
    .customer-message::before,
    .admin-reply::before {
        display: none; /* Hide icons on very small screens */
    }
    
    .btn-submit,
    .search-btn {
        font-size: 16px;
        padding: 12px 25px;
    }
}

/* CSS cho phần phản hồi admin mới */
.admin-reply-section {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
    border-radius: 25px;
    padding: 40px;
    margin-top: 30px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.admin-reply-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    border-radius: 25px 25px 0 0;
}

.reply-header {
    text-align: center;
    margin-bottom: 40px;
    position: relative;
}

.reply-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2rem;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.reply-header h3 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 10px;
    font-size: 1.8rem;
}

.reply-header p {
    color: #7f8c8d;
    margin-bottom: 0;
    font-size: 1.1rem;
}

/* Timeline styles mới */
.reply-timeline {
    position: relative;
    padding: 30px 0;
}

.reply-timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, #667eea, #764ba2);
    border-radius: 2px;
}

.timeline-item {
    position: relative;
    margin-bottom: 40px;
    padding-left: 80px;
    opacity: 0;
    transform: translateX(-30px);
    transition: all 0.6s ease;
}

.timeline-item.animate {
    opacity: 1;
    transform: translateX(0);
}

.timeline-item.latest::before {
    content: 'MỚI NHẤT';
    position: absolute;
    top: -10px;
    left: -65px;
    background: #ff6b6b;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: bold;
}

.timeline-marker {
    position: absolute;
    left: -50px;
    top: 0;
}

.timeline-dot {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: 3px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.timeline-dot.replied {
    border-color: #28a745;
    background: #28a745;
    color: white;
}

.timeline-dot.pending {
    border-color: #ffc107;
    background: #ffc107;
    color: white;
}

.timeline-content {
    flex: 1;
}

.response-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.response-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

.original-message {
    padding: 25px;
    border-bottom: 1px solid #f1f1f1;
}

.message-header {
    margin-bottom: 15px;
}

.message-header h5 {
    color: #2c3e50;
    font-weight: 600;
}

.message-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.message-date {
    color: #6c757d;
    font-size: 14px;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-replied {
    background: #d4edda;
    color: #155724;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.message-body {
    margin-top: 15px;
}

.message-text {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    border-left: 4px solid #007bff;
    margin: 10px 0;
    line-height: 1.6;
}

.message-contact {
    margin-top: 10px;
    color: #6c757d;
    font-size: 14px;
}

.admin-reply {
    padding: 25px;
    background: linear-gradient(135deg, #e8f5e8 0%, #f0f9ff 100%);
}

.reply-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.reply-header h6 {
    color: #28a745;
    font-weight: 600;
    margin: 0;
}

.reply-date {
    color: #6c757d;
    font-size: 13px;
}

.reply-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid #28a745;
    line-height: 1.7;
    box-shadow: 0 2px 10px rgba(40, 167, 69, 0.1);
}

.pending-reply {
    padding: 20px;
    background: #fff8e1;
    text-align: center;
}

.pending-message {
    color: #f57c00;
    font-weight: 500;
}

.response-summary {
    background: white;
    border-radius: 15px;
    padding: 25px;
    margin-top: 20px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.05);
}

.summary-item {
    text-align: center;
    padding: 15px;
}

.summary-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 5px;
}

.summary-label {
    color: #6c757d;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 13px;
}

.no-response-found {
    background: white;
    border-radius: 15px;
    margin-top: 20px;
}

.no-response-icon {
    opacity: 0.6;
}

/* Enhanced admin response styles for timeline */
.response-results {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 30px;
    margin-top: 30px;
}

.result-header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #dee2e6;
}

.result-header h4 {
    color: #2c3e50;
    font-weight: 600;
}

.response-timeline {
    position: relative;
    padding: 20px 0;
}

.response-timeline::before {
    content: '';
    position: absolute;
    left: 30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #43cea2, #185a9d);
}

.timeline-item {
    position: relative;
    margin-bottom: 40px;
    padding-left: 80px;
    opacity: 0;
    transform: translateX(-30px);
    transition: all 0.6s ease;
}

.timeline-item.animate {
    opacity: 1;
    transform: translateX(0);
}

.timeline-item.latest::before {
    content: 'MỚI NHẤT';
    position: absolute;
    top: -10px;
    left: -65px;
    background: #ff6b6b;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: bold;
}

.timeline-marker {
    position: absolute;
    left: -50px;
    top: 0;
}

.timeline-dot {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: 3px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.timeline-dot.replied {
    border-color: #28a745;
    background: #28a745;
    color: white;
}

.timeline-dot.pending {
    border-color: #ffc107;
    background: #ffc107;
    color: white;
}

.timeline-content {
    flex: 1;
}

.response-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.response-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

.original-message {
    padding: 25px;
    border-bottom: 1px solid #f1f1f1;
}

.message-header {
    margin-bottom: 15px;
}

.message-header h5 {
    color: #2c3e50;
    font-weight: 600;
}

.message-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.message-date {
    color: #6c757d;
    font-size: 14px;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-replied {
    background: #d4edda;
    color: #155724;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.message-body {
    margin-top: 15px;
}

.message-text {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    border-left: 4px solid #007bff;
    margin: 10px 0;
    line-height: 1.6;
}

.message-contact {
    margin-top: 10px;
    color: #6c757d;
    font-size: 14px;
}

.admin-reply {
    padding: 25px;
    background: linear-gradient(135deg, #e8f5e8 0%, #f0f9ff 100%);
}

.reply-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.reply-header h6 {
    color: #28a745;
    font-weight: 600;
    margin: 0;
}

.reply-date {
    color: #6c757d;
    font-size: 13px;
}

.reply-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid #28a745;
    line-height: 1.7;
    box-shadow: 0 2px 10px rgba(40, 167, 69, 0.1);
}

.pending-reply {
    padding: 20px;
    background: #fff8e1;
    text-align: center;
}

.pending-message {
    color: #f57c00;
    font-weight: 500;
}

.response-summary {
    background: white;
    border-radius: 15px;
    padding: 25px;
    margin-top: 20px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.05);
}

.summary-item {
    text-align: center;
    padding: 15px;
}

.summary-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 5px;
}

.summary-label {
    color: #6c757d;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 13px;
}

.no-response-found {
    background: white;
    border-radius: 15px;
    margin-top: 20px;
}

.no-response-icon {
    opacity: 0.6;
}

/* Enhanced admin response styles for timeline */
.response-results {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 30px;
    margin-top: 30px;
}

.result-header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #dee2e6;
}

.result-header h4 {
    color: #2c3e50;
    font-weight: 600;
}

.response-timeline {
    position: relative;
    padding: 20px 0;
}

.response-timeline::before {
    content: '';
    position: absolute;
    left: 30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #43cea2, #185a9d);
}

.timeline-item {
    position: relative;
    margin-bottom: 40px;
    padding-left: 80px;
    opacity: 0;
    transform: translateX(-30px);
    transition: all 0.6s ease;
}

.timeline-item.animate {
    opacity: 1;
    transform: translateX(0);
}

.timeline-item.latest::before {
    content: 'MỚI NHẤT';
    position: absolute;
    top: -10px;
    left: -65px;
    background: #ff6b6b;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: bold;
}

.timeline-marker {
    position: absolute;
    left: -50px;
    top: 0;
}

.timeline-dot {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: 3px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.timeline-dot.replied {
    border-color: #28a745;
    background: #28a745;
    color: white;
}

.timeline-dot.pending {
    border-color: #ffc107;
    background: #ffc107;
    color: white;
}

.timeline-content {
    flex: 1;
}

.response-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.response-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

.original-message {
    padding: 25px;
    border-bottom: 1px solid #f1f1f1;
}

.message-header {
    margin-bottom: 15px;
}

.message-header h5 {
    color: #2c3e50;
    font-weight: 600;
}

.message-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.message-date {
    color: #6c757d;
    font-size: 14px;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-replied {
    background: #d4edda;
    color: #155724;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.message-body {
    margin-top: 15px;
}

.message-text {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    border-left: 4px solid #007bff;
    margin: 10px 0;
    line-height: 1.6;
}

.message-contact {
    margin-top: 10px;
    color: #6c757d;
    font-size: 14px;
}

.admin-reply {
    padding: 25px;
    background: linear-gradient(135deg, #e8f5e8 0%, #f0f9ff 100%);
}

.reply-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.reply-header h6 {
    color: #28a745;
    font-weight: 600;
    margin: 0;
}

.reply-date {
    color: #6c757d;
    font-size: 13px;
}

.reply-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid #28a745;
    line-height: 1.7;
    box-shadow: 0 2px 10px rgba(40, 167, 69, 0.1);
}

.pending-reply {
    padding: 20px;
    background: #fff8e1;
    text-align: center;
}

.pending-message {
    color: #f57c00;
    font-weight: 500;
}

.response-summary {
    background: white;
    border-radius: 15px;
    padding: 25px;
    margin-top: 20px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.05);
}

.summary-item {
    text-align: center;
    padding: 15px;
}

.summary-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 5px;
}

.summary-label {
    color: #6c757d;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 13px;
}

.no-response-found {
    background: white;
    border-radius: 15px;
    margin-top: 20px;
}

.no-response-icon {
    opacity: 0.6;
}

/* Enhanced admin response styles for timeline */
.response-results {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 30px;
    margin-top: 30px;
}

.result-header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #dee2e6;
}

.result-header h4 {
    color: #2c3e50;
    font-weight: 600;
}

.response-timeline {
    position: relative;
    padding: 20px 0;
}

.response-timeline::before {
    content: '';
    position: absolute;
    left: 30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #43cea2, #185a9d);
}

.timeline-item {
    position: relative;
    margin-bottom: 40px;
    padding-left: 80px;
    opacity: 0;
    transform: translateX(-30px);
    transition: all 0.6s ease;
}

.timeline-item.animate {
    opacity: 1;
    transform: translateX(0);
}

.timeline-item.latest::before {
    content: 'MỚI NHẤT';
    position: absolute;
    top: -10px;
    left: -65px;
    background: #ff6b6b;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: bold;
}

.timeline-marker {
    position: absolute;
    left: -50px;
    top: 0;
}

.timeline-dot {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: 3px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.timeline-dot.replied {
    border-color: #28a745;
    background: #28a745;
    color: white;
}

.timeline-dot.pending {
    border-color: #ffc107;
    background: #ffc107;
    color: white;
}

.timeline-content {
    flex: 1;
}

.response-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.response-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

.original-message {
    padding: 25px;
    border-bottom: 1px solid #f1f1f1;
}

.message-header {
    margin-bottom: 15px;
}

.message-header h5 {
    color: #2c3e50;
    font-weight: 600;
}

.message-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.message-date {
    color: #6c757d;
    font-size: 14px;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-replied {
    background: #d4edda;
    color: #155724;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.message-body {
    margin-top: 15px;
}

.message-text {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    border-left: 4px solid #007bff;
    margin: 10px 0;
    line-height: 1.6;
}

.message-contact {
    margin-top: 10px;
    color: #6c757d;
    font-size: 14px;
}

.admin-reply {
    padding: 25px;
    background: linear-gradient(135deg, #e8f5e8 0%, #f0f9ff 100%);
}

.reply-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.reply-header h6 {
    color: #28a745;
    font-weight: 600;
    margin: 0;
}

.reply-date {
    color: #6c757d;
    font-size: 13px;
}

.reply-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid #28a745;
    line-height: 1.7;
    box-shadow: 0 2px 10px rgba(40, 167, 69, 0.1);
}

.pending-reply {
    padding: 20px;
    background: #fff8e1;
    text-align: center;
}

.pending-message {
    color: #f57c00;
    font-weight: 500;
}

.response-summary {
    background: white;
    border-radius: 15px;
    padding: 25px;
    margin-top: 20px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.05);
}

.summary-item {
    text-align: center;
    padding: 15px;
}

.summary-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 5px;
}

.summary-label {
    color: #6c757d;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 13px;
}

.no-response-found {
    background: white;
    border-radius: 15px;
    margin-top: 20px;
}

.no-response-icon {
    opacity: 0.6;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .response-timeline::before {
        left: 20px;
    }
    
    .timeline-item {
        padding-left: 60px;
    }
    
    .timeline-marker {
        left: -40px;
    }
    
    .timeline-dot {
        width: 30px;
        height: 30px;
    }
    
    .message-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .reply-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}

/* Animation classes */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.timeline-item {
    animation: slideInUp 0.6s ease forwards;
}

/* Hover effects */
.timeline-dot:hover {
    transform: scale(1.1);
}

.response-card:hover .timeline-dot {
    transform: scale(1.2);
}
</style>

<!-- Hero Section -->
<div class="contact-hero">
    <div class="container text-center">
        <h1 class="display-4 font-weight-bold mb-3">Liên Hệ Với Chúng Tôi</h1>
        <p class="lead">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Contact Info -->
        <div class="col-lg-4 mb-4">
            <div class="contact-info">
                <h3 class="text-center mb-4 font-weight-bold">Thông Tin Liên Hệ</h3>
                
                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Địa chỉ</h5>
                        <p class="mb-0 text-muted">123 Đường ABC, Quận XYZ, TP.HCM</p>
                    </div>
                </div>
                
                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Điện thoại</h5>
                        <p class="mb-0 text-muted">+84 123 456 789</p>
                    </div>
                </div>
                
                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Email</h5>
                        <p class="mb-0 text-muted">contact@yourstore.com</p>
                    </div>
                </div>
                
            
                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Giờ làm việc</h5>
                        <p class="mb-0 text-muted">T2-T6: 8:00-17:00<br>T7: 8:00-12:00</p>
                    </div>
                </div>
                
                <!-- Check Reply Section -->
                <div class="check-reply-section mt-5">
                    <h4 class="text-center mb-4 font-weight-bold text-primary">
                        <i class="fas fa-search mr-2"></i>Kiểm Tra Phản Hồi
                    </h4>
                    <div class="search-form">
                        <form method="GET" action="">
                            <input type="hidden" name="lookup" value="1">
                            <div class="floating-label">
                                <input type="email" class="form-control-custom" name="email" 
                                       value="<?= htmlspecialchars($_GET['email'] ?? '') ?>" required>
                                <label>Email của bạn</label>
                            </div>
                            <div class="floating-label">
                                <input type="number" class="form-control-custom" name="id" 
                                       value="<?= htmlspecialchars($_GET['id'] ?? '') ?>" 
                                       placeholder="Để trống để xem tất cả">
                                <label>Mã liên hệ (tùy chọn)</label>
                            </div>
                            <button type="submit" class="btn search-btn btn-lg btn-block">
                                <i class="fas fa-search mr-2"></i>Tìm kiếm phản hồi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Reply Results Section -->
        <?php if (isset($_GET['lookup']) && isset($reply_data)): ?>
            <div class="col-12 mt-4">
                <div class="admin-reply-section">
                    <div class="reply-header">
                        <div class="reply-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3>💬 Phản Hồi Từ Đội Ngũ Hỗ Trợ</h3>
                        <p>Email: <strong><?= htmlspecialchars($_GET['email']) ?></strong></p>
                    </div>
                    
                    <?php if (empty($reply_data)): ?>
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h4>Không tìm thấy liên hệ nào</h4>
                            <p>Không tìm thấy phản hồi cho email này hoặc liên hệ chưa được xử lý.</p>
                        </div>
                    <?php else: ?>
                        <div class="reply-timeline">
                            <?php foreach ($reply_data as $index => $item): ?>
                                <div class="timeline-item <?= $item['status'] === 'replied' ? 'replied' : 'pending' ?>">
                                    <div class="timeline-marker">
                                        <?php if ($item['status'] === 'replied'): ?>
                                            <i class="fas fa-check-circle"></i>
                                        <?php else: ?>
                                            <i class="fas fa-clock"></i>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="timeline-content">
                                        <div class="contact-card">
                                            <div class="contact-header">
                                                <div class="contact-info">
                                                    <h5><?= htmlspecialchars($item['subject'] ?? 'Liên hệ #' . ($item['id'] ?? '0')) ?></h5>
                                                    <div class="contact-meta">
                                                        <span class="date">
                                                            <i class="fas fa-calendar"></i>
                                                            <?= !empty($item['created_at']) ? date('d/m/Y H:i', strtotime($item['created_at'])) : 'Chưa có ngày' ?>
                                                        </span>
                                                        <span class="status-badge-new status-<?= $item['status'] ?>">
                                                            <?php
                                                            $status_text = [
                                                                'pending' => 'Đang xử lý',
                                                                'read' => 'Đã xem',
                                                                'replied' => 'Đã phản hồi',
                                                                'closed' => 'Đã đóng'
                                                            ];
                                                            echo $status_text[$item['status']] ?? 'Chưa xác định';
                                                            ?>
                                                        </span>
                                                        <span class="priority-badge priority-<?= $item['priority'] ?>">
                                                            <?php
                                                            $priority_text = [
                                                                'low' => 'Thấp',
                                                                'normal' => 'Bình thường', 
                                                                'high' => 'Cao',
                                                                'urgent' => 'Khẩn cấp'
                                                            ];
                                                            echo $priority_text[$item['priority']] ?? 'Bình thường';
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="contact-body">
                                                <div class="original-message">
                                                    <h6><i class="fas fa-user"></i> Tin nhắn của bạn:</h6>
                                                    <p><?= nl2br(htmlspecialchars($item['message'] ?? 'Không có nội dung')) ?></p>
                                                </div>
                                                
                                                <?php if (($item['status'] ?? '') === 'replied' && !empty($item['reply_message'])): ?>
                                                <div class="admin-reply-new">
                                                    <div class="reply-header-small">
                                                        <i class="fas fa-headset"></i>
                                                        <span>Phản hồi từ đội ngũ hỗ trợ</span>
                                                        <?php if (!empty($item['replied_at'])): ?>
                                                            <small class="reply-time">
                                                                <?= date('d/m/Y H:i', strtotime($item['replied_at'])) ?>
                                                            </small>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="reply-content">
                                                        <?= nl2br(htmlspecialchars($item['reply_message'] ?? '')) ?>
                                                    </div>
                                                </div>
                                                <?php else: ?>
                                                <div class="pending-reply">
                                                    <i class="fas fa-hourglass-half"></i>
                                                    <span>Chúng tôi sẽ phản hồi bạn sớm nhất có thể. Cảm ơn bạn đã kiên nhẫn!</span>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="reply-actions">
                            <div class="action-buttons">
                                <button class="btn btn-outline-primary" onclick="scrollToContactForm()">
                                    <i class="fas fa-plus"></i> Gửi liên hệ mới
                                </button>
                                <button class="btn btn-outline-secondary" onclick="window.location.reload()">
                                    <i class="fas fa-refresh"></i> Kiểm tra cập nhật
                                </button>
                            </div>
                            
                            <div class="help-text">
                                <p><i class="fas fa-info-circle"></i> 
                                Bạn sẽ nhận được email thông báo khi chúng tôi phản hồi. 
                                Hãy kiểm tra cả hộp thư spam nếu không thấy email.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="contact-card">
                <div class="contact-header">
                    <h2 class="mb-3">Gửi Tin Nhắn</h2>
                    <p class="mb-0">Hãy để lại thông tin và chúng tôi sẽ phản hồi trong thời gian sớm nhất</p>
                </div>
                
                <div class="contact-form">
                    <form action="index.php?act=lienhe" method="POST" id="contactForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="floating-label">
                                    <input type="text" class="form-control form-control-custom" id="name" name="name" placeholder=" " required>
                                    <label for="name">Họ và tên *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="floating-label">
                                    <input type="email" class="form-control form-control-custom" id="email" name="email" placeholder=" " required>
                                    <label for="email">Email *</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="floating-label">
                                    <input type="tel" class="form-control form-control-custom" id="phone" name="phone" placeholder=" ">
                                    <label for="phone">Số điện thoại</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="floating-label">
                                    <select class="form-control form-control-custom" id="subject" name="subject" required>
                                        <option value="">Chọn chủ đề</option>
                                        <option value="Hỏi về sản phẩm">Hỏi về sản phẩm</option>
                                        <option value="Hỗ trợ đơn hàng">Hỗ trợ đơn hàng</option>
                                        <option value="Khiếu nại">Khiếu nại</option>
                                        <option value="Góp ý">Góp ý</option>
                                        <option value="Hợp tác">Hợp tác</option>
                                        <option value="Khác">Khác</option>
                                    </select>
                                    <label for="subject">Chủ đề *</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="floating-label">
                            <textarea class="form-control form-control-custom" id="message" name="message" rows="5" placeholder=" " required></textarea>
                            <label for="message">Nội dung *</label>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-submit btn-lg">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Gửi Tin Nhắn
                            </button>
                        </div>
                    </form>
                    
                    <?php if (isset($success) && $success): ?>
                        <div class="alert alert-success-custom alert-custom text-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($error) && $error): ?>
                        <div class="alert alert-error-custom alert-custom text-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Có lỗi xảy ra. Vui lòng thử lại sau!
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Form kiểm tra phản hồi admin ngay dưới form liên hệ -->
            <div class="contact-card mt-4">
                <div class="contact-header" style="background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);">
                    <h3 class="mb-3">
                        <i class="fas fa-search mr-2"></i>
                        Kiểm Tra Phản Hồi Từ Admin
                    </h3>
                    <p class="mb-0">Nhập email để xem lịch sử liên hệ và phản hồi từ chúng tôi</p>
                </div>
                
                <div class="contact-form">
                    <form action="index.php?act=lienhe" method="POST" id="responseCheckForm">
                        <input type="hidden" name="check_response" value="1">
                        
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <div class="floating-label">
                                    <input type="email" class="form-control form-control-custom" id="check_email" name="check_email" 
                                           placeholder=" " required value="<?= htmlspecialchars($_POST['check_email'] ?? '') ?>">
                                    <label for="check_email">Email đã sử dụng để liên hệ *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-submit w-100" style="background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);">
                                    <i class="fas fa-search mr-2"></i>
                                    Kiểm Tra
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Hiển thị kết quả kiểm tra phản hồi -->
                    <?php if (isset($_POST['check_response']) && !empty($_POST['check_email'])): ?>
                        <?php
                        $checkEmail = filter_var($_POST['check_email'], FILTER_SANITIZE_EMAIL);
                        require_once __DIR__ . '/../models/LienHe.php';
                        $responseHistory = LienHe::getAllByEmail($checkEmail);
                        ?>
                        
                        <div class="response-results mt-4">
                            <div class="result-header">
                                <h4 class="mb-3">
                                    <i class="fas fa-history mr-2"></i>
                                    Lịch Sử Liên Hệ & Phản Hồi
                                </h4>
                                <p class="text-muted">Email: <strong><?= htmlspecialchars($checkEmail) ?></strong></p>
                            </div>

                            <?php if (!empty($responseHistory)): ?>
                                <div class="response-timeline">
                                    <?php foreach ($responseHistory as $index => $item): ?>
                                        <div class="timeline-item <?= $index === 0 ? 'latest' : '' ?>">
                                            <div class="timeline-marker">
                                                <div class="timeline-dot <?= !empty($item['admin_reply']) ? 'replied' : 'pending' ?>">
                                                    <i class="fas <?= !empty($item['admin_reply']) ? 'fa-check' : 'fa-clock' ?>"></i>
                                                </div>
                                            </div>
                                            
                                            <div class="timeline-content">
                                                <div class="response-card">
                                                    <!-- Tin nhắn gốc -->
                                                    <div class="original-message">
                                                        <div class="message-header">
                                                            <h5 class="mb-1">
                                                                <i class="fas fa-envelope mr-2"></i>
                                                                <?= htmlspecialchars($item['chu_de'] ?? 'Không có chủ đề') ?>
                                                            </h5>
                                                            <div class="message-meta">
                                                                <span class="message-date">
                                                                    <i class="fas fa-calendar mr-1"></i>
                                                                    <?= !empty($item['ngay_gui']) ? date('d/m/Y H:i', strtotime($item['ngay_gui'])) : 'Chưa có ngày' ?>
                                                                </span>
                                                                <span class="status-badge <?= !empty($item['admin_reply']) ? 'status-replied' : 'status-pending' ?>">
                                                                    <?= !empty($item['admin_reply']) ? 'Đã phản hồi' : 'Chờ phản hồi' ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="message-body">
                                                            <p><strong>Nội dung:</strong></p>
                                                            <div class="message-text">
                                                                <?= nl2br(htmlspecialchars($item['noi_dung'] ?? 'Không có nội dung')) ?>
                                                            </div>
                                                            
                                                            <?php if (!empty($item['so_dien_thoai'])): ?>
                                                                <p class="message-contact">
                                                                    <i class="fas fa-phone mr-1"></i>
                                                                    SĐT: <?= htmlspecialchars($item['so_dien_thoai'] ?? '') ?>
                                                                </p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <!-- Phản hồi từ admin -->
                                                    <?php if (!empty($item['admin_reply'])): ?>
                                                        <div class="admin-reply">
                                                            <div class="reply-header">
                                                                <h6 class="mb-2">
                                                                    <i class="fas fa-reply mr-2"></i>
                                                                    Phản Hồi Từ Admin
                                                                </h6>
                                                                <span class="reply-date">
                                                                    <i class="fas fa-clock mr-1"></i>
                                                                    <?= !empty($item['reply_date']) ? date('d/m/Y H:i', strtotime($item['reply_date'])) : 'Chưa có ngày' ?>
                                                                </span>
                                                            </div>
                                                            <div class="reply-content">
                                                                <?= nl2br(htmlspecialchars($item['admin_reply'] ?? '')) ?>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="pending-reply">
                                                            <div class="pending-message">
                                                                <i class="fas fa-hourglass-half mr-2 text-warning"></i>
                                                                <span>Chúng tôi đang xử lý yêu cầu của bạn. Vui lòng kiên nhẫn chờ đợi.</span>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="response-summary mt-4">
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <div class="summary-item">
                                                <div class="summary-number"><?= count($responseHistory) ?></div>
                                                <div class="summary-label">Tổng liên hệ</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="summary-item">
                                                <div class="summary-number">
                                                    <?= count(array_filter($responseHistory, function($item) { return !empty($item['admin_reply']); })) ?>
                                                </div>
                                                <div class="summary-label">Đã phản hồi</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="summary-item">
                                                <div class="summary-number">
                                                    <?= count(array_filter($responseHistory, function($item) { return empty($item['admin_reply']); })) ?>
                                                </div>
                                                <div class="summary-label">Chờ phản hồi</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="no-response-found">
                                    <div class="text-center py-5">
                                        <div class="no-response-icon">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        </div>
                                        <h5 class="text-muted">Không tìm thấy lịch sử liên hệ</h5>
                                        <p class="text-muted mb-0">
                                            Có thể bạn chưa từng liên hệ với email này hoặc email không chính xác.
                                        </p>
                                        <button type="button" class="btn btn-outline-primary mt-3" onclick="document.getElementById('check_email').focus()">
                                            <i class="fas fa-redo mr-2"></i>
                                            Thử email khác
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    // Add loading state
    const submitBtn = this.querySelector('.btn-submit');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang gửi...';
    submitBtn.disabled = true;
    
    // Re-enable after 3 seconds (in case of page reload issues)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 3000);
});

// Enhanced form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        const forms = document.getElementsByClassName('needs-validation');
        const validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Search form enhancements
document.addEventListener('DOMContentLoaded', function() {
    // Add loading state to search button
    const searchForm = document.querySelector('form[action=""]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang tìm kiếm...';
            submitBtn.disabled = true;
            
            // Re-enable after 5 seconds
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });
    }
    
    // Smooth scroll to results
    const resultsSection = document.querySelector('.reply-results-section');
    if (resultsSection) {
        setTimeout(() => {
            resultsSection.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 100);
    }
    
    // Auto-focus email field if lookup is active
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('lookup') && !urlParams.get('email')) {
        const emailField = document.querySelector('input[name="email"]');
        if (emailField) {
            emailField.focus();
        }
    }
    
    // Add confirmation before clearing search
    const clearSearchBtn = document.createElement('button');
    clearSearchBtn.type = 'button';
    clearSearchBtn.className = 'btn btn-outline-secondary btn-sm mt-2';
    clearSearchBtn.innerHTML = '<i class="fas fa-times mr-1"></i>Xóa tìm kiếm';
    clearSearchBtn.onclick = function() {
        if (confirm('Bạn có muốn xóa kết quả tìm kiếm không?')) {
            window.location.href = window.location.pathname;
        }
    };
    
    // Add clear button if search results exist
    if (resultsSection) {
        const searchSection = document.querySelector('.check-reply-section');
        if (searchSection) {
            const searchForm = searchSection.querySelector('.search-form');
            searchForm.appendChild(clearSearchBtn);
        }
    }
    
    // Add tooltips for status badges
    const statusBadges = document.querySelectorAll('.status-badge');
    statusBadges.forEach(badge => {
        const statusText = badge.textContent.trim();
        let tooltipText = '';
        
        switch(statusText) {
            case 'Chờ xử lý':
                tooltipText = 'Liên hệ đang chờ được xem xét';
                break;
            case 'Đã đọc':
                tooltipText = 'Nhân viên đã xem liên hệ của bạn';
                break;
            case 'Đã phản hồi':
                tooltipText = 'Đã có phản hồi từ nhân viên';
                break;
            case 'Đã đóng':
                tooltipText = 'Liên hệ đã được xử lý xong';
                break;
        }
        
        if (tooltipText) {
            badge.setAttribute('title', tooltipText);
            badge.setAttribute('data-toggle', 'tooltip');
        }
    });
    
    // Initialize Bootstrap tooltips if available
    if (typeof $ !== 'undefined' && $.fn.tooltip) {
        $('[data-toggle="tooltip"]').tooltip();
    }
    
    // Add copy email functionality
    const copyEmailBtn = document.createElement('button');
    copyEmailBtn.type = 'button';
    copyEmailBtn.className = 'btn btn-outline-info btn-sm ml-2';
    copyEmailBtn.innerHTML = '<i class="fas fa-copy"></i>';
    copyEmailBtn.title = 'Sao chép email';
    copyEmailBtn.onclick = function() {
        const email = document.querySelector('input[name="email"]').value;
        if (email) {
            navigator.clipboard.writeText(email).then(() => {
                this.innerHTML = '<i class="fas fa-check"></i>';
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-copy"></i>';
                }, 2000);
            });
        }
    };
    
    // Add copy button to email field
    const emailField = document.querySelector('input[name="email"]');
    if (emailField && emailField.value) {
        emailField.parentNode.appendChild(copyEmailBtn);
    }
});

// Add real-time character counter for message field
const messageField = document.getElementById('message');
if (messageField) {
    const charCounter = document.createElement('small');
    charCounter.className = 'text-muted float-right mt-1';
    charCounter.style.fontSize = '12px';
    
    const updateCounter = () => {
        const length = messageField.value.length;
        charCounter.textContent = `${length}/1000 ký tự`;
        
        if (length > 800) {
            charCounter.className = 'text-warning float-right mt-1';
        } else if (length > 950) {
            charCounter.className = 'text-danger float-right mt-1';
        } else {
            charCounter.className = 'text-muted float-right mt-1';
        }
    };
    
    messageField.parentNode.appendChild(charCounter);
    messageField.addEventListener('input', updateCounter);
    updateCounter();
}

// Functions for new reply section
function scrollToContactForm() {
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
        // Focus on name field
        const nameField = document.getElementById('name');
        if (nameField) {
            setTimeout(() => nameField.focus(), 500);
        }
    }
}

// Add animation effects for admin reply section
document.addEventListener('DOMContentLoaded', function() {
    // Animate timeline items on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = '0s';
                entry.target.classList.add('animate');
            }
        });
    }, observerOptions);

    // Observe all timeline items
    const timelineItems = document.querySelectorAll('.timeline-item');
    timelineItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.2}s`;
        observer.observe(item);
    });
    
    // Add typing effect to admin replies
    const adminReplies = document.querySelectorAll('.admin-reply-new .reply-content');
    adminReplies.forEach(reply => {
        const text = reply.textContent;
        reply.textContent = '';
        let index = 0;
        
        const typeWriter = () => {
            if (index < text.length) {
                reply.textContent += text.charAt(index);
                index++;
                setTimeout(typeWriter, 30);
            }
        };
        
        // Start typing effect when element is visible
        const replyObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(typeWriter, 500);
                    replyObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        replyObserver.observe(reply);
    });
    
    // Add hover effects for contact cards
    const contactCards = document.querySelectorAll('.contact-card');
    contactCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-5px) scale(1)';
        });
    });
    
    // Add notification for new replies
    const repliedItems = document.querySelectorAll('.timeline-item.replied');
    if (repliedItems.length > 0) {
        setTimeout(() => {
            const notification = document.createElement('div');
            notification.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 350px;">
                    <strong><i class="fas fa-bell mr-2"></i>Thông báo!</strong> 
                    Bạn có ${repliedItems.length} phản hồi mới từ đội ngũ hỗ trợ.
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            `;
            document.body.appendChild(notification);
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }, 1000);
    }
});
</script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
