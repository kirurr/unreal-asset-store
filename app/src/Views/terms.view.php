<?php

use Entities\Category;

/** @var Category[] $trendingCategories */

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <? renderComponent('head'); ?>
    <script src="/js/splide/splide.min.js"></script>
    <script src="/js/main-carousel.js" defer></script>
    <title>Unreal Asset Store</title>
</head>

<body>
    <header class="header">
        <? renderComponent('navbar', ['categories' => $trendingCategories]); ?>
    </header>
    <main>
        <section class="my-6 p-0">
            <h1>Terms and Conditions</h1>
            <p>
                At <strong>Unreal Asset Store</strong>, we are committed to protecting your privacy. This Privacy Policy
                outlines how we collect, use, and safeguard your information when you visit our website or make a
                purchase.
            </p>
        </section>

        <section class="mb-6 p-0">
            <h2>Information We Collect</h2>
            <p>
                We may collect the following types of information:
            </p>
            <ul class="list-disc list-inside mb-4">
                <li><strong>Personal Information</strong>: Name, email address, billing address, and shipping address.</li>
                <li><strong>Payment Information</strong>: Credit card details and other payment information.</li>
                <li><strong>Usage Data</strong>: Information about how you use our website and services.</li>
            </ul>
        </section>

        <section class="mb-6 p-0">
            <h2>How We Use Your Information</h2>
            <p>
                We use the information we collect for various purposes, including:
            </p>
            <ul class="list-disc list-inside mb-4">
                <li>Processing your orders and managing your account.</li>
                <li>Improving our website and services.</li>
                <li>Communicating with you about your orders and promotions.</li>
                <li>Analyzing usage trends to enhance user experience.</li>
            </ul>
        </section>

        <section class="mb-6 p-0">
            <h2>Data Security</h2>
            <p>
                We take the security of your personal information seriously. We implement a variety of security
                measures to protect your data from unauthorized access, alteration, disclosure, or destruction.
            </p>
        </section>

        <section class="mb-6 p-0">
            <h2>Cookies</h2>
            <p>
                Our website uses cookies to enhance your experience. Cookies are small files stored on your device
                that help us remember your preferences and improve our services. You can choose to accept or decline
                cookies through your browser settings.
            </p>
        </section>

        <section class="mb-6 p-0">
            <h2>Your Rights</h2>
            <p>
                You have the right to:
            </p>
            <ul class="list-disc list-inside mb-4">
                <li>Access the personal information we hold about you.</li>
                <li>Request correction of any inaccurate information.</li>
                <li>Request deletion of your personal information.</li>
                <li>Opt-out of marketing communications.</li>
            </ul>
        </section>

        <section class="mb-6 p-0">
            <h2>Changes to This Privacy Policy</h2>
            <p>
                We may update our Privacy Policy from time to time. We will notify you of any changes by posting the
                new Privacy Policy on this page. We encourage you to review this Privacy Policy periodically for
                any updates.
            </p>
        </section>
    </main>
    <? renderComponent('footer', ['categories' => $trendingCategories]); ?>
</body>

</html>