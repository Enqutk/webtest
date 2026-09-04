@props(['id' => null, 'label'])
<div @if($id) id="{{ $id }}" @endif class="scroll-mt-4 pt-3 first:pt-0">
    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ $label }}</span>
</div>
