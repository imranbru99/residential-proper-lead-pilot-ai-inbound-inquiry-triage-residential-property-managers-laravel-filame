<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ResidentialProperLeadPilot Feature Modules
    |--------------------------------------------------------------------------
    | Toggle modules per property-management business needs. Core triage
    | modules default ON; niche / integration modules default OFF.
    */

    'definitions' => [
        'inbound_inquiry_triage' => [
            'name' => 'Inbound Inquiry Triage',
            'description' => 'Capture website, phone, and email inquiries into a unified intake queue for leasing and resident ops.',
            'category' => 'core',
            'enabled' => true,
        ],
        'ai_classification' => [
            'name' => 'AI Classification',
            'description' => 'Classify inquiries by leasing intent, maintenance urgency, and qualification score.',
            'category' => 'ai',
            'enabled' => true,
        ],
        'human_approval_workflow' => [
            'name' => 'Human Approval Workflow',
            'description' => 'Require staff approval before converting classified leads to CRM opportunities.',
            'category' => 'core',
            'enabled' => true,
        ],
        'crm_opportunities' => [
            'name' => 'CRM Opportunities',
            'description' => 'Create and manage qualified leasing / management opportunities from approved inquiries.',
            'category' => 'sales',
            'enabled' => true,
        ],
        'properties' => [
            'name' => 'Properties',
            'description' => 'Operate on multifamily and SFR portfolios with unit counts and fair-housing notes.',
            'category' => 'operations',
            'enabled' => true,
        ],
        'residents_prospects' => [
            'name' => 'Residents & Prospects',
            'description' => 'Track prospective renters, owners, and current residents linked to inquiries.',
            'category' => 'operations',
            'enabled' => true,
        ],
        'service_requests' => [
            'name' => 'Maintenance Requests',
            'description' => 'Convert opportunities into resident maintenance requests for properties.',
            'category' => 'operations',
            'enabled' => true,
        ],
        'field_technicians' => [
            'name' => 'Vendors',
            'description' => 'Manage licensed vendors, specialties, and availability for work orders.',
            'category' => 'operations',
            'enabled' => true,
        ],
        'job_tickets' => [
            'name' => 'Vendor Work Orders',
            'description' => 'Dispatch vendor work orders with compliance checklists.',
            'category' => 'operations',
            'enabled' => true,
        ],
        'audit_log' => [
            'name' => 'Audit Log',
            'description' => 'Immutable trail of classify, approve, convert, and dispatch actions for tenant privacy.',
            'category' => 'compliance',
            'enabled' => true,
        ],
        'messaging_consent' => [
            'name' => 'Messaging Consent',
            'description' => 'Track SMS/email consent for TCPA-aware leasing follow-ups.',
            'category' => 'compliance',
            'enabled' => true,
        ],
        'fair_housing_guardrails' => [
            'name' => 'Fair Housing Guardrails',
            'description' => 'Flag protected-class language risks and require human review before outreach.',
            'category' => 'compliance',
            'enabled' => true,
        ],
        'follow_up_drafts' => [
            'name' => 'Follow-Up Drafts',
            'description' => 'AI-assisted draft replies awaiting human approval before send.',
            'category' => 'sales',
            'enabled' => true,
        ],
        'slug_engine' => [
            'name' => 'Universal Slug Engine',
            'description' => 'Generate URL-safe slugs for properties and public lead pages (local laravel-universal-slug equivalent).',
            'category' => 'platform',
            'enabled' => true,
        ],
        'customer_portal' => [
            'name' => 'Resident Portal',
            'description' => 'Let prospects and residents check inquiry status (optional niche module).',
            'category' => 'portal',
            'enabled' => false,
        ],
        'attendance_hub' => [
            'name' => 'Attendance Hub',
            'description' => 'Staff / vendor clock-in integration (local laravel-attendance-hub equivalent).',
            'category' => 'hr',
            'enabled' => false,
        ],
        'unicode_pdf_exports' => [
            'name' => 'Unicode PDF Exports',
            'description' => 'Export triage reports and work orders as PDF (local laravel-unicode-pdf equivalent).',
            'category' => 'documents',
            'enabled' => false,
        ],
        'ai_catalog_scrape' => [
            'name' => 'AI Catalog / Listing Enrichment',
            'description' => 'Enrich leads from online listing sources (local laravel-ai-catalog equivalent).',
            'category' => 'ai',
            'enabled' => false,
        ],
        'ai_hub' => [
            'name' => 'AI Hub Provider Switch',
            'description' => 'Route classification through pluggable AI providers (local laravel-ai-hub equivalent).',
            'category' => 'ai',
            'enabled' => true,
        ],
        'drutogoti_speed' => [
            'name' => 'Drutogoti Speed Layer',
            'description' => 'Caching and queue acceleration helpers (local drutogoti equivalent).',
            'category' => 'platform',
            'enabled' => true,
        ],
        'admin_panel_extras' => [
            'name' => 'Admin Panel Extras',
            'description' => 'Extended Filament admin dashboard widgets (local laravel-admin-panel equivalent).',
            'category' => 'platform',
            'enabled' => true,
        ],
        'integrations_appfolio' => [
            'name' => 'AppFolio Integration',
            'description' => 'Sync opportunities and residents to AppFolio.',
            'category' => 'integrations',
            'enabled' => false,
        ],
        'integrations_buildium' => [
            'name' => 'Buildium Integration',
            'description' => 'Push qualified leasing leads into Buildium.',
            'category' => 'integrations',
            'enabled' => false,
        ],
        'integrations_quickbooks' => [
            'name' => 'QuickBooks / Accounting Integration',
            'description' => 'Link won opportunities to accounting customers.',
            'category' => 'integrations',
            'enabled' => false,
        ],
        'integrations_email' => [
            'name' => 'Email Inbox Integration',
            'description' => 'Ingest leasing@ / maintenance@ mailboxes into triage.',
            'category' => 'integrations',
            'enabled' => false,
        ],
        'multi_location' => [
            'name' => 'Multi-Property Portfolio',
            'description' => 'Route inquiries by property / portfolio region.',
            'category' => 'operations',
            'enabled' => false,
        ],
    ],
];
