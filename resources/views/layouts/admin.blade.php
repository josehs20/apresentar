<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --primary: #6B4F3A;
            --primary-light: #8B6F5A;
            --secondary: #A67C52;
            --accent: #2E5E4E;
            --accent-light: #3A7A66;
            --light: #F5F1EB;
            --light-2: #EDE7DE;
            --dark: #2B2B2B;
            --sidebar-width: 260px;
            --sidebar-collapsed: 70px;
            --topbar-height: 64px;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow-sm: 0 1px 3px rgba(43,43,43,0.06), 0 1px 2px rgba(43,43,43,0.04);
            --shadow-md: 0 4px 12px rgba(43,43,43,0.08), 0 2px 4px rgba(43,43,43,0.04);
            --shadow-lg: 0 10px 30px rgba(43,43,43,0.1), 0 4px 8px rgba(43,43,43,0.04);
            --transition: 0.2s ease;
        }

        * { font-family: 'Inter', sans-serif; }

        body {
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--dark);
            color: #c4b8ae;
            z-index: 1040;
            transition: width var(--transition);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .sidebar:hover { width: var(--sidebar-width); }
        .sidebar.collapsed { width: var(--sidebar-collapsed); }
        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .sidebar-badge,
        .sidebar.collapsed .sidebar-arrow { display: none; }
        .sidebar.collapsed .sidebar-logo-text { opacity: 0; width: 0; overflow: hidden; }
        .sidebar.collapsed:hover .sidebar-text,
        .sidebar.collapsed:hover .sidebar-badge,
        .sidebar.collapsed:hover .sidebar-arrow { display: inline-block; }
        .sidebar.collapsed:hover .sidebar-logo-text { opacity: 1; width: auto; overflow: visible; }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            min-height: var(--topbar-height);
            flex-shrink: 0;
        }
        .sidebar-brand .brand-icon {
            width: 36px;
            height: 36px;
            background: var(--accent);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #fff;
            flex-shrink: 0;
        }
        .sidebar-brand .sidebar-logo-text {
            font-weight: 700;
            font-size: 18px;
            color: #fff;
            white-space: nowrap;
            transition: opacity var(--transition);
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .sidebar-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: rgba(255,255,255,0.25);
            padding: 12px 12px 6px;
            white-space: nowrap;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            color: #c4b8ae;
            text-decoration: none;
            transition: all var(--transition);
            white-space: nowrap;
            margin-bottom: 2px;
        }
        .sidebar-item:hover {
            background: rgba(255,255,255,0.06);
            color: #fff;
        }
        .sidebar-item.active {
            background: var(--accent);
            color: #fff;
            font-weight: 500;
        }
        .sidebar-item .sidebar-icon {
            font-size: 18px;
            width: 22px;
            text-align: center;
            flex-shrink: 0;
        }
        .sidebar-item .sidebar-text { flex: 1; }
        .sidebar-arrow { font-size: 12px; opacity: 0.5; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid rgba(43,43,43,0.06);
            z-index: 1030;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            transition: left var(--transition);
        }
        .sidebar.collapsed ~ .topbar { left: var(--sidebar-collapsed); }

        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-toggle {
            background: none; border: none; font-size: 22px; color: var(--dark);
            cursor: pointer; padding: 4px; border-radius: var(--radius-sm); transition: background var(--transition);
        }
        .topbar-toggle:hover { background: var(--light); }
        .topbar-right { display: flex; align-items: center; gap: 8px; }
        .topbar-user {
            display: flex; align-items: center; gap: 10px; padding: 6px 12px;
            border-radius: var(--radius-sm); cursor: pointer; transition: background var(--transition);
            text-decoration: none; color: var(--dark);
        }
        .topbar-user:hover { background: var(--light); }
        .topbar-avatar {
            width: 34px; height: 34px; border-radius: 50%; background: var(--primary);
            color: #fff; display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 14px;
        }
        .topbar-username { font-size: 14px; font-weight: 500; }

        /* ===== MAIN ===== */
        .main-content {
            margin-left: var(--sidebar-width); margin-top: var(--topbar-height);
            padding: 28px 32px; min-height: calc(100vh - var(--topbar-height)); transition: margin-left var(--transition);
        }
        .sidebar.collapsed ~ .main-content { margin-left: var(--sidebar-collapsed); }

        .page-header {
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;
            gap: 12px; margin-bottom: 28px;
        }
        .page-header h3 { font-weight: 700; font-size: 22px; color: var(--dark); margin: 0; }
        .page-header p { color: #8a8a8a; font-size: 14px; margin: 2px 0 0 0; }

        /* ===== CARDS ===== */
        .card-stat {
            border: none; border-radius: var(--radius); box-shadow: var(--shadow-sm);
            transition: all var(--transition); cursor: default;
        }
        .card-stat:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); }
        .card-stat .card-body { padding: 20px 24px; }
        .card-stat-icon {
            width: 48px; height: 48px; border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center; font-size: 22px;
        }
        .card-custom { border: none; border-radius: var(--radius); box-shadow: var(--shadow-sm); transition: box-shadow var(--transition); }
        .card-custom:hover { box-shadow: var(--shadow-md); }
        .card-custom .card-header {
            background: #fff; border-bottom: 1px solid rgba(43,43,43,0.06); padding: 16px 20px;
            font-weight: 600; font-size: 14px; border-radius: var(--radius) var(--radius) 0 0 !important;
        }

        /* ===== TABLES ===== */
        .table-admin { margin: 0; }
        .table-admin thead th {
            background: var(--dark); color: #fff; font-weight: 500; font-size: 12px;
            text-transform: uppercase; letter-spacing: 0.04em; padding: 12px 16px; border: none;
        }
        .table-admin tbody td { padding: 12px 16px; vertical-align: middle; border-bottom: 1px solid rgba(43,43,43,0.04); }
        .table-admin tbody tr:hover { background: rgba(107,79,58,0.03); }

        /* ===== DATATABLES OVERRIDE ===== */
        .dataTables_wrapper { padding: 16px; font-family: 'Inter', sans-serif; }
        .dataTables_wrapper .dataTables_info { font-size: 13px; color: #8a8a8a; padding-top: 12px; }
        .dataTables_wrapper .dataTables_paginate { text-align: center !important; padding-top: 12px; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            display: inline-block; padding: 4px 10px; margin: 0 2px; font-size: 13px;
            border: 1px solid rgba(43,43,43,0.12); border-radius: var(--radius-sm); background: #fff;
            color: var(--dark); cursor: pointer; transition: all var(--transition);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--primary); border-color: var(--primary); color: #fff;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary) !important; border-color: var(--primary) !important; color: #fff !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4; cursor: default; background: #fff !important; color: #8a8a8a !important;
        }
        .dataTables_wrapper .dataTables_filter { margin-bottom: 8px; }
        .dataTables_wrapper .dataTables_filter input { border-radius: var(--radius-sm); border: 1px solid rgba(43,43,43,0.12); padding: 8px 12px; font-size: 14px; outline: none; }
        .dataTables_wrapper .dataTables_filter input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(107,79,58,0.1); }
        .dataTables_wrapper .dataTables_length { margin-bottom: 8px; }
        .dataTables_wrapper .dataTables_length select { border-radius: var(--radius-sm); border: 1px solid rgba(43,43,43,0.12); padding: 6px 10px; font-size: 14px; }
        table.dataTable thead th { background: var(--dark) !important; color: #fff !important; font-size: 12px !important; text-transform: uppercase; border: none !important; letter-spacing: 0.04em; }
        table.dataTable tbody td { padding: 12px 16px !important; vertical-align: middle; border-bottom: 1px solid rgba(43,43,43,0.04) !important; }
        table.dataTable tbody tr:hover { background: rgba(107,79,58,0.03) !important; }
        table.dataTable { border-collapse: collapse !important; }

        /* ===== BADGES ===== */
        .badge-status { padding: 4px 12px; font-weight: 500; font-size: 12px; border-radius: 20px; }
        .badge-status.active { background: #d4edda; color: #155724; }
        .badge-status.inactive { background: #f8d7da; color: #721c24; }

        /* ===== BUTTONS ===== */
        .btn-primary-custom {
            background: var(--primary); border-color: var(--primary); color: #fff;
            border-radius: var(--radius-sm); font-weight: 500; padding: 8px 20px; transition: all var(--transition);
        }
        .btn-primary-custom:hover {
            background: var(--primary-light); border-color: var(--primary-light); color: #fff;
            transform: translateY(-1px); box-shadow: var(--shadow-md);
        }
        .btn-outline-custom {
            border: 1px solid rgba(43,43,43,0.12); color: var(--dark); border-radius: var(--radius-sm);
            font-weight: 500; padding: 8px 20px; transition: all var(--transition);
        }
        .btn-outline-custom:hover { border-color: var(--primary); color: var(--primary); background: rgba(107,79,58,0.04); }
        .btn-danger-custom {
            background: #dc3545; border: none; color: #fff; border-radius: var(--radius-sm);
            font-weight: 500; padding: 8px 20px; transition: all var(--transition);
        }
        .btn-danger-custom:hover { background: #c82333; transform: translateY(-1px); box-shadow: var(--shadow-md); }
        .btn-icon {
            width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
            border-radius: var(--radius-sm); border: 1px solid rgba(43,43,43,0.1); background: #fff;
            color: var(--dark); transition: all var(--transition); text-decoration: none; font-size: 15px;
        }
        .btn-icon:hover { border-color: var(--primary); color: var(--primary); }
        .btn-icon.danger:hover { border-color: #dc3545; color: #dc3545; }

        /* ===== FORMS ===== */
        .form-custom {
            border: 1px solid rgba(43,43,43,0.12); border-radius: var(--radius-sm); padding: 10px 14px;
            font-size: 14px; transition: border-color var(--transition), box-shadow var(--transition);
        }
        .form-custom:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(107,79,58,0.1); }
        .form-label-custom { font-weight: 600; font-size: 13px; color: var(--dark); margin-bottom: 6px; }

        .chart-placeholder {
            height: 260px; background: linear-gradient(135deg, var(--light) 0%, var(--light-2) 100%);
            border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center;
            color: #b0a89c; font-size: 14px;
        }
        .alert-custom { border: none; border-radius: var(--radius-sm); padding: 12px 16px; }
        .modal-custom .modal-content { border: none; border-radius: var(--radius); box-shadow: var(--shadow-lg); }
        .modal-custom .modal-header { border-bottom: 1px solid rgba(43,43,43,0.06); padding: 20px 24px; }
        .modal-custom .modal-body { padding: 20px 24px; }
        .modal-custom .modal-footer { border-top: 1px solid rgba(43,43,43,0.06); padding: 16px 24px; }

        @media (max-width: 768px) {
            .sidebar { width: var(--sidebar-collapsed); }
            .sidebar .sidebar-text, .sidebar .sidebar-badge, .sidebar .sidebar-arrow, .sidebar .sidebar-logo-text { display: none; }
            .sidebar:hover { width: var(--sidebar-width); box-shadow: var(--shadow-lg); }
            .sidebar:hover .sidebar-text, .sidebar:hover .sidebar-badge, .sidebar:hover .sidebar-arrow, .sidebar:hover .sidebar-logo-text { display: inline-block; }
            .topbar { left: var(--sidebar-collapsed); }
            .main-content { margin-left: var(--sidebar-collapsed); padding: 20px 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <x-sidebar />
    <x-topbar />

    <div class="main-content">
        @yield('content')
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // CSRF header for axios
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

        // Toastr config
        toastr.options = { closeButton: true, progressBar: true, positionClass: 'toast-top-right', timeOut: 4000, extendedTimeOut: 2000, preventDuplicates: true };

        // DataTables default config
        $.extend($.fn.dataTable.defaults, {
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Nenhum registro encontrado",
                infoFiltered: "(filtrado de _MAX_ registros)",
                paginate: { first: "Primeiro", last: "Último", next: "Próximo", previous: "Anterior" },
                zeroRecords: "Nenhum registro encontrado"
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            order: [],
            responsive: true,
            autoWidth: false,
        });

        // Helper: reload a table container from a server route
        function reloadTable(tableContainerId, tableUrl, tableId) {
            axios.get(tableUrl).then(response => {
                // Destroy old DataTable if exists
                const container = document.getElementById(tableContainerId);
                const oldTable = container.querySelector('table');
                if (oldTable && $.fn.DataTable.isDataTable(oldTable)) {
                    $(oldTable).DataTable().destroy();
                }
                // Replace content
                container.innerHTML = response.data;
                // Reinit DataTable
                const newTable = document.querySelector('#' + tableId);
                if (newTable) {
                    $(newTable).DataTable({ order: [] });
                }
            });
        }

        // Toggle sidebar
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            if (toggle && sidebar) {
                toggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    sidebar.classList.toggle('collapsed');
                });
            }
        });
    </script>
    @if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    </script>
@endif
@if(session('success'))
<script>
    toastr.success("{{ session('success') }}");
</script>
@endif
    @stack('scripts')
</body>
</html>