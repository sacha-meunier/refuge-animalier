@props([
    'message' => __('pagination.no_data'),
])

<tr>
    <td colspan="100" class="h-32 text-center text-sm text-muted-foreground">
        {{ $message }}
    </td>
</tr>
