/**
 * Modern Dashboard JavaScript - Complete Component System
 * Handles all dashboard functionality and interactions
 */

class ModernDashboardManager {
    constructor() {
        this.charts = {};
        this.widgets = {};
        this.notifications = [];
        this.sidebarCollapsed = false;
        this.activeFilters = {};
        this.refreshIntervals = {};
        this.init();
    }

    init() {
        this.setupSidebar();
        this.setupNotifications();
        this.setupWidgets();
        this.setupCharts();
        this.setupDataTables();
        this.setupModals();
        this.setupFilters();
        this.setupSearch();
        this.setupTheme();
        this.setupRealTimeUpdates();
        this.setupKeyboardShortcuts();
        this.setupTooltips();
        this.loadDashboardData();
    }

    // ===========================================
    // SIDEBAR MANAGEMENT
    // ===========================================
    setupSidebar() {
        const sidebar = document.querySelector('.modern-sidebar');
        const toggleBtn = document.querySelector('.sidebar-toggle');
        const overlay = document.querySelector('.sidebar-overlay');

        if (!sidebar) return;

        // Toggle sidebar
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                this.toggleSidebar();
            });
        }

        // Close sidebar on overlay click (mobile)
        if (overlay) {
            overlay.addEventListener('click', () => {
                this.closeSidebar();
            });
        }

        // Setup menu items
        this.setupMenuItems();
        
        // Restore sidebar state
        this.restoreSidebarState();
    }

    toggleSidebar() {
        const sidebar = document.querySelector('.modern-sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        
        this.sidebarCollapsed = !this.sidebarCollapsed;
        
        if (sidebar) {
            sidebar.classList.toggle('collapsed', this.sidebarCollapsed);
        }
        
        if (overlay) {
            overlay.classList.toggle('active', !this.sidebarCollapsed);
        }
        
        // Save state
        localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);
        
        // Trigger resize event for charts
        setTimeout(() => {
            window.dispatchEvent(new Event('resize'));
        }, 300);
    }

    closeSidebar() {
        const sidebar = document.querySelector('.modern-sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        
        this.sidebarCollapsed = true;
        
        if (sidebar) {
            sidebar.classList.add('collapsed');
        }
        
        if (overlay) {
            overlay.classList.remove('active');
        }
    }

    setupMenuItems() {
        const menuItems = document.querySelectorAll('.menu-item');
        
        menuItems.forEach(item => {
            const link = item.querySelector('a');
            const submenu = item.querySelector('.submenu');
            
            // Handle submenu toggle
            if (submenu) {
                const toggle = item.querySelector('.submenu-toggle');
                if (toggle) {
                    toggle.addEventListener('click', (e) => {
                        e.preventDefault();
                        this.toggleSubmenu(item);
                    });
                }
            }
            
            // Handle active state
            if (link) {
                link.addEventListener('click', () => {
                    this.setActiveMenuItem(item);
                });
            }
        });
        
        // Set initial active state
        this.setInitialActiveMenuItem();
    }

    toggleSubmenu(menuItem) {
        const submenu = menuItem.querySelector('.submenu');
        const isOpen = menuItem.classList.contains('open');
        
        // Close all other submenus
        document.querySelectorAll('.menu-item.open').forEach(item => {
            if (item !== menuItem) {
                item.classList.remove('open');
            }
        });
        
        // Toggle current submenu
        menuItem.classList.toggle('open', !isOpen);
    }

    setActiveMenuItem(menuItem) {
        // Remove active class from all items
        document.querySelectorAll('.menu-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Add active class to current item
        menuItem.classList.add('active');
        
        // If it's a submenu item, also activate parent
        const parentSubmenu = menuItem.closest('.submenu');
        if (parentSubmenu) {
            const parentItem = parentSubmenu.closest('.menu-item');
            if (parentItem) {
                parentItem.classList.add('active');
            }
        }
    }

    setInitialActiveMenuItem() {
        const currentPath = window.location.pathname;
        const menuLinks = document.querySelectorAll('.menu-item a');
        
        menuLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                const menuItem = link.closest('.menu-item');
                this.setActiveMenuItem(menuItem);
            }
        });
    }

    restoreSidebarState() {
        const saved = localStorage.getItem('sidebarCollapsed');
        if (saved === 'true') {
            this.toggleSidebar();
        }
    }

    // ===========================================
    // NOTIFICATIONS SYSTEM
    // ===========================================
    setupNotifications() {
        this.createNotificationContainer();
        this.setupNotificationButton();
        this.loadNotifications();
    }

    createNotificationContainer() {
        if (!document.querySelector('.notifications-container')) {
            const container = document.createElement('div');
            container.className = 'notifications-container';
            document.body.appendChild(container);
        }
    }

    setupNotificationButton() {
        const notificationBtn = document.querySelector('.notification-btn');
        const notificationPanel = document.querySelector('.notification-panel');
        
        if (notificationBtn && notificationPanel) {
            notificationBtn.addEventListener('click', () => {
                notificationPanel.classList.toggle('active');
            });
            
            // Close on outside click
            document.addEventListener('click', (e) => {
                if (!notificationBtn.contains(e.target) && !notificationPanel.contains(e.target)) {
                    notificationPanel.classList.remove('active');
                }
            });
        }
    }

    showNotification(message, type = 'info', duration = 5000) {
        const container = document.querySelector('.notifications-container');
        if (!container) return;

        const notification = document.createElement('div');
        notification.className = `modern-notification notification-${type}`;
        
        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };
        
        notification.innerHTML = `
            <div class="notification-icon">
                <i class="${icons[type] || icons.info}"></i>
            </div>
            <div class="notification-content">
                <div class="notification-message">${message}</div>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        // Add close functionality
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            this.removeNotification(notification);
        });
        
        // Add to container
        container.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // Auto remove
        if (duration > 0) {
            setTimeout(() => {
                this.removeNotification(notification);
            }, duration);
        }
        
        return notification;
    }

    removeNotification(notification) {
        notification.classList.add('removing');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }

    loadNotifications() {
        // Simulate loading notifications
        this.notifications = [
            {
                id: 1,
                message: 'New enquiry received',
                type: 'info',
                time: new Date(),
                read: false
            },
            {
                id: 2,
                message: 'System backup completed',
                type: 'success',
                time: new Date(Date.now() - 3600000),
                read: false
            }
        ];
        
        this.updateNotificationBadge();
    }

    updateNotificationBadge() {
        const badge = document.querySelector('.notification-badge');
        const unreadCount = this.notifications.filter(n => !n.read).length;
        
        if (badge) {
            badge.textContent = unreadCount;
            badge.style.display = unreadCount > 0 ? 'flex' : 'none';
        }
    }

    // ===========================================
    // WIDGETS MANAGEMENT
    // ===========================================
    setupWidgets() {
        this.setupStatsWidgets();
        this.setupChartWidgets();
        this.setupTableWidgets();
        this.setupRefreshButtons();
    }

    setupStatsWidgets() {
        const statsWidgets = document.querySelectorAll('.stats-widget');
        
        statsWidgets.forEach(widget => {
            this.animateCounter(widget);
            this.setupWidgetActions(widget);
        });
    }

    animateCounter(widget) {
        const counter = widget.querySelector('.stat-number');
        if (!counter) return;
        
        const target = parseInt(counter.getAttribute('data-target') || counter.textContent.replace(/,/g, ''));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.textContent = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toLocaleString();
            }
        };
        
        // Start animation when widget comes into view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        observer.observe(widget);
    }

    setupWidgetActions(widget) {
        const refreshBtn = widget.querySelector('.widget-refresh');
        const expandBtn = widget.querySelector('.widget-expand');
        const menuBtn = widget.querySelector('.widget-menu');
        
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => {
                this.refreshWidget(widget);
            });
        }
        
        if (expandBtn) {
            expandBtn.addEventListener('click', () => {
                this.expandWidget(widget);
            });
        }
        
        if (menuBtn) {
            menuBtn.addEventListener('click', () => {
                this.showWidgetMenu(widget, menuBtn);
            });
        }
    }

    refreshWidget(widget) {
        const refreshBtn = widget.querySelector('.widget-refresh');
        if (refreshBtn) {
            refreshBtn.classList.add('spinning');
            
            // Simulate refresh
            setTimeout(() => {
                refreshBtn.classList.remove('spinning');
                this.showNotification('Widget refreshed successfully', 'success', 3000);
            }, 1000);
        }
    }

    expandWidget(widget) {
        widget.classList.toggle('expanded');
        
        // Refresh charts after expansion
        setTimeout(() => {
            const chartCanvas = widget.querySelector('canvas');
            if (chartCanvas && this.charts[chartCanvas.id]) {
                this.charts[chartCanvas.id].resize();
            }
        }, 300);
    }

    // ===========================================
    // CHARTS MANAGEMENT
    // ===========================================
    setupCharts() {
        this.initializeCharts();
        this.setupChartControls();
    }

    initializeCharts() {
        // Revenue Chart
        this.createRevenueChart();
        
        // User Growth Chart
        this.createUserGrowthChart();
        
        // Orders Chart
        this.createOrdersChart();
        
        // Traffic Sources Chart
        this.createTrafficChart();
    }

    createRevenueChart() {
        const canvas = document.getElementById('revenueChart');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        
        this.charts.revenue = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    createUserGrowthChart() {
        const canvas = document.getElementById('userGrowthChart');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        
        this.charts.userGrowth = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'New Users',
                    data: [120, 190, 150, 250],
                    backgroundColor: '#10b981',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    createOrdersChart() {
        const canvas = document.getElementById('ordersChart');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        
        this.charts.orders = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [65, 25, 10],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    createTrafficChart() {
        const canvas = document.getElementById('trafficChart');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        
        this.charts.traffic = new Chart(ctx, {
            type: 'polarArea',
            data: {
                labels: ['Direct', 'Social', 'Email', 'Search'],
                datasets: [{
                    data: [30, 25, 20, 25],
                    backgroundColor: [
                        '#4f46e5',
                        '#06b6d4',
                        '#84cc16',
                        '#f59e0b'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    setupChartControls() {
        const chartPeriodBtns = document.querySelectorAll('.chart-period-btn');
        
        chartPeriodBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const period = btn.dataset.period;
                const chartId = btn.closest('.chart-widget').querySelector('canvas').id;
                
                // Update active button
                btn.parentElement.querySelectorAll('.chart-period-btn').forEach(b => {
                    b.classList.remove('active');
                });
                btn.classList.add('active');
                
                // Update chart data
                this.updateChartData(chartId, period);
            });
        });
    }

    updateChartData(chartId, period) {
        const chart = this.charts[chartId.replace('Chart', '')];
        if (!chart) return;
        
        // Simulate data update based on period
        const newData = this.generateChartData(period);
        chart.data.datasets[0].data = newData;
        chart.update();
    }

    generateChartData(period) {
        // Generate sample data based on period
        const dataPoints = period === 'week' ? 7 : period === 'month' ? 30 : 365;
        return Array.from({length: dataPoints}, () => Math.floor(Math.random() * 1000) + 100);
    }

    // ===========================================
    // DATA TABLES MANAGEMENT
    // ===========================================
    setupDataTables() {
        this.initializeDataTables();
        this.setupTableActions();
        this.setupTableFilters();
    }

    initializeDataTables() {
        const tables = document.querySelectorAll('.modern-data-table');
        
        tables.forEach(table => {
            this.enhanceTable(table);
        });
    }

    enhanceTable(table) {
        // Add sorting functionality
        this.addTableSorting(table);
        
        // Add search functionality
        this.addTableSearch(table);
        
        // Add pagination
        this.addTablePagination(table);
        
        // Add row selection
        this.addRowSelection(table);
    }

    addTableSorting(table) {
        const headers = table.querySelectorAll('th[data-sort]');
        
        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => {
                this.sortTable(table, header.dataset.sort, header);
            });
        });
    }

    sortTable(table, column, header) {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const isAscending = !header.classList.contains('sort-asc');
        
        // Remove sort classes from all headers
        table.querySelectorAll('th').forEach(h => {
            h.classList.remove('sort-asc', 'sort-desc');
        });
        
        // Add sort class to current header
        header.classList.add(isAscending ? 'sort-asc' : 'sort-desc');
        
        // Sort rows
        rows.sort((a, b) => {
            const aValue = this.getTableCellValue(a, column);
            const bValue = this.getTableCellValue(b, column);
            
            if (isAscending) {
                return aValue > bValue ? 1 : -1;
            } else {
                return aValue < bValue ? 1 : -1;
            }
        });
        
        // Reorder rows
        rows.forEach(row => tbody.appendChild(row));
    }

    getTableCellValue(row, column) {
        const cell = row.querySelector(`[data-column="${column}"]`);
        return cell ? cell.textContent.trim() : '';
    }

    addTableSearch(table) {
        const searchInput = table.parentElement.querySelector('.table-search');
        if (!searchInput) return;
        
        searchInput.addEventListener('input', (e) => {
            this.filterTable(table, e.target.value);
        });
    }

    filterTable(table, searchTerm) {
        const rows = table.querySelectorAll('tbody tr');
        const term = searchTerm.toLowerCase();
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
        
        this.updateTableInfo(table);
    }

    addRowSelection(table) {
        const selectAllCheckbox = table.querySelector('thead input[type="checkbox"]');
        const rowCheckboxes = table.querySelectorAll('tbody input[type="checkbox"]');
        
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', () => {
                rowCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                this.updateBulkActions(table);
            });
        }
        
        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                this.updateBulkActions(table);
            });
        });
    }

    updateBulkActions(table) {
        const checkedBoxes = table.querySelectorAll('tbody input[type="checkbox"]:checked');
        const bulkActions = table.parentElement.querySelector('.bulk-actions');
        
        if (bulkActions) {
            bulkActions.style.display = checkedBoxes.length > 0 ? 'flex' : 'none';
        }
    }

    // ===========================================
    // MODALS MANAGEMENT
    // ===========================================
    setupModals() {
        this.createModalOverlay();
        this.setupModalTriggers();
        this.setupModalClose();
    }

    createModalOverlay() {
        if (!document.querySelector('.modal-overlay')) {
            const overlay = document.createElement('div');
            overlay.className = 'modal-overlay';
            document.body.appendChild(overlay);
        }
    }

    setupModalTriggers() {
        document.addEventListener('click', (e) => {
            const modalTrigger = e.target.closest('[data-modal]');
            if (modalTrigger) {
                e.preventDefault();
                const modalId = modalTrigger.dataset.modal;
                this.openModal(modalId);
            }
        });
    }

    setupModalClose() {
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-overlay') || 
                e.target.classList.contains('modal-close')) {
                this.closeModal();
            }
        });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeModal();
            }
        });
    }

    openModal(modalId) {
        const modal = document.getElementById(modalId);
        const overlay = document.querySelector('.modal-overlay');
        
        if (modal && overlay) {
            modal.classList.add('active');
            overlay.classList.add('active');
            document.body.classList.add('modal-open');
        }
    }

    closeModal() {
        const activeModal = document.querySelector('.modern-modal.active');
        const overlay = document.querySelector('.modal-overlay');
        
        if (activeModal) {
            activeModal.classList.remove('active');
        }
        
        if (overlay) {
            overlay.classList.remove('active');
        }
        
        document.body.classList.remove('modal-open');
    }

    // ===========================================
    // FILTERS AND SEARCH
    // ===========================================
    setupFilters() {
        this.setupDateRangeFilters();
        this.setupDropdownFilters();
        this.setupAdvancedFilters();
    }

    setupDateRangeFilters() {
        const dateInputs = document.querySelectorAll('.date-filter');
        
        dateInputs.forEach(input => {
            input.addEventListener('change', () => {
                this.applyFilters();
            });
        });
    }

    setupDropdownFilters() {
        const filterDropdowns = document.querySelectorAll('.filter-dropdown');
        
        filterDropdowns.forEach(dropdown => {
            dropdown.addEventListener('change', () => {
                this.applyFilters();
            });
        });
    }

    setupAdvancedFilters() {
        const advancedFilterBtn = document.querySelector('.advanced-filters-btn');
        const advancedFiltersPanel = document.querySelector('.advanced-filters');
        
        if (advancedFilterBtn && advancedFiltersPanel) {
            advancedFilterBtn.addEventListener('click', () => {
                advancedFiltersPanel.classList.toggle('active');
            });
        }
    }

    applyFilters() {
        const filters = this.collectFilterValues();
        this.activeFilters = filters;
        
        // Apply filters to tables and charts
        this.filterDashboardData(filters);
        
        // Show applied filters
        this.showAppliedFilters(filters);
    }

    collectFilterValues() {
        const filters = {};
        
        document.querySelectorAll('.filter-input').forEach(input => {
            if (input.value) {
                filters[input.name] = input.value;
            }
        });
        
        return filters;
    }

    filterDashboardData(filters) {
        // Update tables
        document.querySelectorAll('.modern-data-table').forEach(table => {
            this.applyTableFilters(table, filters);
        });
        
        // Update charts
        Object.keys(this.charts).forEach(chartKey => {
            this.updateChartWithFilters(this.charts[chartKey], filters);
        });
    }

    // ===========================================
    // SEARCH FUNCTIONALITY
    // ===========================================
    setupSearch() {
        const globalSearch = document.querySelector('.global-search');
        
        if (globalSearch) {
            globalSearch.addEventListener('input', (e) => {
                this.performGlobalSearch(e.target.value);
            });
        }
    }

    performGlobalSearch(query) {
        if (query.length < 2) {
            this.clearSearchResults();
            return;
        }
        
        // Simulate search
        const results = this.searchDashboardContent(query);
        this.showSearchResults(results);
    }

    searchDashboardContent(query) {
        // Simulate search results
        return [
            { type: 'user', title: 'John Doe', description: 'User account' },
            { type: 'order', title: 'Order #1234', description: 'Recent order' },
            { type: 'product', title: 'Sample Product', description: 'Product item' }
        ].filter(item => 
            item.title.toLowerCase().includes(query.toLowerCase()) ||
            item.description.toLowerCase().includes(query.toLowerCase())
        );
    }

    showSearchResults(results) {
        const searchResults = document.querySelector('.search-results');
        if (!searchResults) return;
        
        searchResults.innerHTML = results.map(result => `
            <div class="search-result-item">
                <div class="result-icon">
                    <i class="fas fa-${this.getResultIcon(result.type)}"></i>
                </div>
                <div class="result-content">
                    <div class="result-title">${result.title}</div>
                    <div class="result-description">${result.description}</div>
                </div>
            </div>
        `).join('');
        
        searchResults.style.display = 'block';
    }

    getResultIcon(type) {
        const icons = {
            user: 'user',
            order: 'shopping-cart',
            product: 'box',
            default: 'search'
        };
        return icons[type] || icons.default;
    }

    clearSearchResults() {
        const searchResults = document.querySelector('.search-results');
        if (searchResults) {
            searchResults.style.display = 'none';
        }
    }

    // ===========================================
    // THEME MANAGEMENT
    // ===========================================
    setupTheme() {
        this.loadThemePreference();
        this.setupThemeToggle();
    }

    loadThemePreference() {
        const savedTheme = localStorage.getItem('dashboardTheme') || 'light';
        this.setTheme(savedTheme);
    }

    setupThemeToggle() {
        const themeToggle = document.querySelector('.theme-toggle');
        
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                this.toggleTheme();
            });
        }
    }

    toggleTheme() {
        const currentTheme = document.body.getAttribute('data-theme') || 'light';
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        this.setTheme(newTheme);
    }

    setTheme(theme) {
        document.body.setAttribute('data-theme', theme);
        localStorage.setItem('dashboardTheme', theme);
        
        // Update charts colors if needed
        this.updateChartsTheme(theme);
    }

    updateChartsTheme(theme) {
        const isDark = theme === 'dark';
        const textColor = isDark ? '#ffffff' : '#374151';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
        
        Object.values(this.charts).forEach(chart => {
            if (chart.options.scales) {
                Object.keys(chart.options.scales).forEach(scaleKey => {
                    if (chart.options.scales[scaleKey].ticks) {
                        chart.options.scales[scaleKey].ticks.color = textColor;
                    }
                    if (chart.options.scales[scaleKey].grid) {
                        chart.options.scales[scaleKey].grid.color = gridColor;
                    }
                });
            }
            chart.update();
        });
    }

    // ===========================================
    // REAL-TIME UPDATES
    // ===========================================
    setupRealTimeUpdates() {
        this.startRealTimeUpdates();
        this.setupRefreshControls();
    }

    startRealTimeUpdates() {
        // Update stats every 30 seconds
        this.refreshIntervals.stats = setInterval(() => {
            this.updateStatsWidgets();
        }, 30000);
        
        // Update notifications every 60 seconds
        this.refreshIntervals.notifications = setInterval(() => {
            this.loadNotifications();
        }, 60000);
    }

    updateStatsWidgets() {
        const statsWidgets = document.querySelectorAll('.stats-widget .stat-number');
        
        statsWidgets.forEach(stat => {
            const currentValue = parseInt(stat.textContent.replace(/,/g, ''));
            const newValue = currentValue + Math.floor(Math.random() * 10);
            stat.textContent = newValue.toLocaleString();
        });
    }

    setupRefreshControls() {
        const refreshBtn = document.querySelector('.refresh-dashboard');
        
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => {
                this.refreshDashboard();
            });
        }
    }

    refreshDashboard() {
        this.showNotification('Refreshing dashboard...', 'info', 2000);
        
        // Refresh all components
        setTimeout(() => {
            this.updateStatsWidgets();
            this.loadNotifications();
            Object.values(this.charts).forEach(chart => chart.update());
            this.showNotification('Dashboard refreshed successfully', 'success', 3000);
        }, 1000);
    }

    // ===========================================
    // KEYBOARD SHORTCUTS
    // ===========================================
    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + K for search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                const searchInput = document.querySelector('.global-search');
                if (searchInput) {
                    searchInput.focus();
                }
            }
            
            // Ctrl/Cmd + B for sidebar toggle
            if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                e.preventDefault();
                this.toggleSidebar();
            }
            
            // Ctrl/Cmd + R for refresh
            if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                e.preventDefault();
                this.refreshDashboard();
            }
        });
    }

    // ===========================================
    // TOOLTIPS
    // ===========================================
    setupTooltips() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        
        tooltipElements.forEach(element => {
            this.addTooltip(element);
        });
    }

    addTooltip(element) {
        let tooltip;
        
        element.addEventListener('mouseenter', () => {
            tooltip = this.createTooltip(element.dataset.tooltip);
            document.body.appendChild(tooltip);
            this.positionTooltip(tooltip, element);
        });
        
        element.addEventListener('mouseleave', () => {
            if (tooltip && tooltip.parentNode) {
                tooltip.parentNode.removeChild(tooltip);
            }
        });
    }

    createTooltip(text) {
        const tooltip = document.createElement('div');
        tooltip.className = 'modern-tooltip';
        tooltip.textContent = text;
        return tooltip;
    }

    positionTooltip(tooltip, element) {
        const rect = element.getBoundingClientRect();
        const tooltipRect = tooltip.getBoundingClientRect();
        
        tooltip.style.left = rect.left + (rect.width - tooltipRect.width) / 2 + 'px';
        tooltip.style.top = rect.top - tooltipRect.height - 10 + 'px';
    }

    // ===========================================
    // DATA LOADING
    // ===========================================
    loadDashboardData() {
        this.showLoadingState();
        
        // Simulate data loading
        setTimeout(() => {
            this.hideLoadingState();
            this.showNotification('Dashboard loaded successfully', 'success', 3000);
        }, 1500);
    }

    showLoadingState() {
        const loadingElements = document.querySelectorAll('.widget-content');
        loadingElements.forEach(element => {
            element.classList.add('loading');
        });
    }

    hideLoadingState() {
        const loadingElements = document.querySelectorAll('.widget-content');
        loadingElements.forEach(element => {
            element.classList.remove('loading');
        });
    }

    // ===========================================
    // UTILITY METHODS
    // ===========================================
    updateTableInfo(table) {
        const visibleRows = table.querySelectorAll('tbody tr:not([style*="display: none"])');
        const totalRows = table.querySelectorAll('tbody tr');
        const info = table.parentElement.querySelector('.table-info');
        
        if (info) {
            info.textContent = `Showing ${visibleRows.length} of ${totalRows.length} entries`;
        }
    }

    formatNumber(num) {
        return new Intl.NumberFormat().format(num);
    }

    formatCurrency(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    }

    formatDate(date) {
        return new Intl.DateTimeFormat('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        }).format(new Date(date));
    }

    // ===========================================
    // CLEANUP
    // ===========================================
    destroy() {
        // Clear intervals
        Object.values(this.refreshIntervals).forEach(interval => {
            clearInterval(interval);
        });
        
        // Destroy charts
        Object.values(this.charts).forEach(chart => {
            chart.destroy();
        });
        
        // Remove event listeners
        // This would be more complex in a real implementation
    }
}

// Global functions for backward compatibility
function toggleSidebar() {
    if (window.dashboardManager) {
        window.dashboardManager.toggleSidebar();
    }
}

function showNotification(message, type, duration) {
    if (window.dashboardManager) {
        return window.dashboardManager.showNotification(message, type, duration);
    }
}

function refreshWidget(widgetId) {
    if (window.dashboardManager) {
        const widget = document.getElementById(widgetId);
        if (widget) {
            window.dashboardManager.refreshWidget(widget);
        }
    }
}

function openModal(modalId) {
    if (window.dashboardManager) {
        window.dashboardManager.openModal(modalId);
    }
}

function closeModal() {
    if (window.dashboardManager) {
        window.dashboardManager.closeModal();
    }
}

// Initialize dashboard when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.dashboardManager = new ModernDashboardManager();
});

// Handle page unload
window.addEventListener('beforeunload', () => {
    if (window.dashboardManager) {
        window.dashboardManager.destroy();
    }
});