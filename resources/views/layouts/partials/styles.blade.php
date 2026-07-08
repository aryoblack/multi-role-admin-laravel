<style>
    /* Legacy Bootstrap compatibility styles */
    .btn {
        @apply inline-flex items-center justify-center gap-2 px-4 py-2 border border-transparent text-sm font-semibold rounded-lg shadow-sm transition-all duration-200;
    }
    
    .btn-primary {
        @apply bg-blue-600 text-white focus:ring-2 focus:ring-blue-500 focus:ring-offset-2;
        &:hover { @apply bg-blue-700; }
    }
    
    .btn-secondary {
        @apply bg-gray-600 text-white focus:ring-2 focus:ring-gray-500 focus:ring-offset-2;
        &:hover { @apply bg-gray-700; }
    }
    
    .btn-success {
        @apply bg-green-600 text-white focus:ring-2 focus:ring-green-500 focus:ring-offset-2;
        &:hover { @apply bg-green-700; }
    }
    
    .btn-danger {
        @apply bg-red-600 text-white focus:ring-2 focus:ring-red-500 focus:ring-offset-2;
        &:hover { @apply bg-red-700; }
    }
    
    .btn-warning {
        @apply bg-yellow-500 text-white focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2;
        &:hover { @apply bg-yellow-600; }
    }
    
    .btn-info {
        @apply bg-cyan-600 text-white focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2;
        &:hover { @apply bg-cyan-700; }
    }
    
    .btn-light {
        @apply bg-white text-gray-700 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2;
        &:hover { @apply bg-gray-50; }
    }
    
    .btn-sm {
        @apply px-3 py-1.5 text-xs;
    }
    
    .badge {
        @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
    }
    
    .badge.bg-primary {
        @apply bg-blue-100 text-blue-800;
    }
    
    .badge.bg-success {
        @apply bg-green-100 text-green-800;
    }
    
    .badge.bg-danger {
        @apply bg-red-100 text-red-800;
    }
    
    .badge.bg-warning {
        @apply bg-yellow-100 text-yellow-800;
    }
    
    .badge.bg-info {
        @apply bg-cyan-100 text-cyan-800;
    }
    
    .badge.bg-secondary {
        @apply bg-gray-100 text-gray-800;
    }
    
    .card {
        @apply bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden;
    }
    
    .card-header {
        @apply bg-gray-50 border-b border-gray-200 px-6 py-4;
    }
    
    .card-body {
        @apply p-6;
    }
    
    .form-control, .form-select {
        @apply block w-full px-4 py-2.5 text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200;
    }
    
    .form-label {
        @apply block mb-2 text-sm font-semibold text-gray-700;
    }
    
    .table {
        @apply w-full text-sm text-left;
    }
    
    .table thead {
        @apply text-xs text-gray-700 uppercase bg-gray-50;
    }
    
    .table th {
        @apply px-6 py-3 font-semibold;
    }
    
    .table td {
        @apply px-6 py-4;
    }
    
    .table-hover tbody tr {
        @apply transition-colors duration-150;
        &:hover { @apply bg-gray-50; }
    }
    
    .alert {
        @apply p-4 rounded-lg border-l-4;
    }
    
    .alert-success {
        @apply bg-green-50 border-green-500 text-green-800;
    }
    
    .alert-danger {
        @apply bg-red-50 border-red-500 text-red-800;
    }
    
    .alert-warning {
        @apply bg-yellow-50 border-yellow-500 text-yellow-800;
    }
    
    .alert-info {
        @apply bg-blue-50 border-blue-500 text-blue-800;
    }
</style>
