@if ($invoice->notes != '' && $invoice->notes != null)
    <div class="notes" style="text-align: justify; text-justify: inter-word;">
        <div class="notes-label">
            Notas:
        </div>
        {!! nl2br(htmlspecialchars($invoice->notes)) !!}
    </div>
@endif
