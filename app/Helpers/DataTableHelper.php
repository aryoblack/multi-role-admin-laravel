<?php

namespace App\Helpers;

class DataTableHelper
{
    /**
     * Generate modern action buttons for DataTable
     *
     * @param array $config
     * @return string
     */
    public static function actionButtons(array $config): string
    {
        $html = '<div class="flex items-center justify-center gap-2">';

        // View Button
        if (isset($config['view'])) {
            $html .= sprintf(
                '<a href="%s" class="dt-action-btn dt-action-btn-view" title="%s">
                    <i class="fas fa-eye"></i>
                    <span class="hidden sm:inline">%s</span>
                </a>',
                $config['view']['url'],
                $config['view']['title'] ?? 'Lihat',
                $config['view']['text'] ?? 'Lihat'
            );
        }

        // Edit Button
        if (isset($config['edit'])) {
            $class = isset($config['edit']['class']) ? $config['edit']['class'] : 'edit-btn';
            $dataId = isset($config['edit']['id']) ? 'data-id="' . $config['edit']['id'] . '"' : '';
            
            if (isset($config['edit']['url'])) {
                $html .= sprintf(
                    '<a href="%s" class="dt-action-btn dt-action-btn-edit %s" %s title="%s">
                        <i class="fas fa-edit"></i>
                        <span class="hidden sm:inline">%s</span>
                    </a>',
                    $config['edit']['url'],
                    $class,
                    $dataId,
                    $config['edit']['title'] ?? 'Edit',
                    $config['edit']['text'] ?? 'Edit'
                );
            } else {
                $html .= sprintf(
                    '<button type="button" class="dt-action-btn dt-action-btn-edit %s" %s title="%s">
                        <i class="fas fa-edit"></i>
                        <span class="hidden sm:inline">%s</span>
                    </button>',
                    $class,
                    $dataId,
                    $config['edit']['title'] ?? 'Edit',
                    $config['edit']['text'] ?? 'Edit'
                );
            }
        }

        // Delete Button
        if (isset($config['delete'])) {
            $disabled = isset($config['delete']['disabled']) && $config['delete']['disabled'] ? 'disabled' : '';
            $class = isset($config['delete']['class']) ? $config['delete']['class'] : 'delete-btn';
            
            $html .= sprintf(
                '<button type="button" class="dt-action-btn dt-action-btn-delete %s" data-id="%s" %s title="%s">
                    <i class="fas fa-trash"></i>
                    <span class="hidden sm:inline">%s</span>
                </button>',
                $class,
                $config['delete']['id'],
                $disabled,
                $config['delete']['title'] ?? 'Hapus',
                $config['delete']['text'] ?? 'Hapus'
            );
        }

        // Custom Buttons
        if (isset($config['custom']) && is_array($config['custom'])) {
            foreach ($config['custom'] as $button) {
                $btnClass = $button['class'] ?? 'dt-action-btn-primary';
                $html .= sprintf(
                    '<a href="%s" class="dt-action-btn %s" title="%s">
                        <i class="%s"></i>
                        <span class="hidden sm:inline">%s</span>
                    </a>',
                    $button['url'],
                    $btnClass,
                    $button['title'] ?? '',
                    $button['icon'] ?? 'fas fa-cog',
                    $button['text'] ?? ''
                );
            }
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Generate compact action buttons (icon only)
     *
     * @param array $config
     * @return string
     */
    public static function compactActionButtons(array $config): string
    {
        $html = '<div class="flex items-center justify-center gap-2">';

        // View Button
        if (isset($config['view'])) {
            $html .= sprintf(
                '<a href="%s" class="dt-action-btn-compact dt-action-btn-view" title="%s">
                    <i class="fas fa-eye text-sm"></i>
                </a>',
                $config['view']['url'],
                $config['view']['title'] ?? 'Lihat'
            );
        }

        // Edit Button
        if (isset($config['edit'])) {
            $class = isset($config['edit']['class']) ? $config['edit']['class'] : 'edit-btn';
            $dataId = isset($config['edit']['id']) ? 'data-id="' . $config['edit']['id'] . '"' : '';
            
            if (isset($config['edit']['url'])) {
                $html .= sprintf(
                    '<a href="%s" class="dt-action-btn-compact dt-action-btn-edit %s" %s title="%s">
                        <i class="fas fa-edit text-sm"></i>
                    </a>',
                    $config['edit']['url'],
                    $class,
                    $dataId,
                    $config['edit']['title'] ?? 'Edit'
                );
            } else {
                $html .= sprintf(
                    '<button type="button" class="dt-action-btn-compact dt-action-btn-edit %s" %s title="%s">
                        <i class="fas fa-edit text-sm"></i>
                    </button>',
                    $class,
                    $dataId,
                    $config['edit']['title'] ?? 'Edit'
                );
            }
        }

        // Delete Button
        if (isset($config['delete'])) {
            $disabled = isset($config['delete']['disabled']) && $config['delete']['disabled'] ? 'disabled' : '';
            $class = isset($config['delete']['class']) ? $config['delete']['class'] : 'delete-btn';
            
            $html .= sprintf(
                '<button type="button" class="dt-action-btn-compact dt-action-btn-delete %s" data-id="%s" %s title="%s">
                    <i class="fas fa-trash text-sm"></i>
                </button>',
                $class,
                $config['delete']['id'],
                $disabled,
                $config['delete']['title'] ?? 'Hapus'
            );
        }

        // Custom Buttons
        if (isset($config['custom']) && is_array($config['custom'])) {
            foreach ($config['custom'] as $button) {
                $btnClass = $button['class'] ?? 'dt-action-btn-primary';
                $html .= sprintf(
                    '<a href="%s" class="dt-action-btn-compact %s" title="%s">
                        <i class="%s text-sm"></i>
                    </a>',
                    $button['url'],
                    $btnClass,
                    $button['title'] ?? '',
                    $button['icon'] ?? 'fas fa-cog'
                );
            }
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Generate badge
     *
     * @param string $text
     * @param string $type (primary, success, warning, danger, info)
     * @return string
     */
    public static function badge(string $text, string $type = 'primary'): string
    {
        return sprintf(
            '<span class="dt-badge dt-badge-%s">%s</span>',
            $type,
            $text
        );
    }

    /**
     * Generate status badge
     *
     * @param string $status
     * @return string
     */
    public static function statusBadge(string $status): string
    {
        $badges = [
            'active' => ['text' => 'Active', 'type' => 'success'],
            'inactive' => ['text' => 'Inactive', 'type' => 'danger'],
            'pending' => ['text' => 'Pending', 'type' => 'warning'],
            'completed' => ['text' => 'Completed', 'type' => 'success'],
            'cancelled' => ['text' => 'Cancelled', 'type' => 'danger'],
        ];

        $badge = $badges[strtolower($status)] ?? ['text' => ucfirst($status), 'type' => 'primary'];

        return self::badge($badge['text'], $badge['type']);
    }
}
