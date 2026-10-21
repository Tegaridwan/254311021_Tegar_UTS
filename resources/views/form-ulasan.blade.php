<div class="border border-[#dde1ea] rounded-[32px] p-6 bg-white">
    <h2 class="text-xl font-bold mb-4">Tulis Ulasan</h2>

    @if(session('success'))
        <div class="px-4 py-3 rounded-[10px] mb-4 text-sm bg-[#e6f6ed] text-[#22a35a]">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="px-4 py-3 rounded-[10px] mb-4 text-sm bg-[#fff3cd] text-[#856404]">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('ulasan.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="hidden" name="Id_Penjual" value="{{ $penjual->Id_Penjual }}">

        <div>
            <label for="Nama_Pembeli" class="block text-sm font-bold mb-1.5">Nama Anda</label>
            <input id="Nama_Pembeli" name="Nama_Pembeli" type="text" value="{{ old('Nama_Pembeli') }}"
                maxlength="100" required
                class="w-full px-3 py-2.5 border border-[#dde1ea] rounded-lg outline-none">
        </div>

        <div>
            <label for="Rating" class="block text-sm font-bold mb-1.5">Rating</label>
            <select id="Rating" name="Rating" required
                    class="w-full px-3 py-2.5 border border-[#dde1ea] rounded-lg outline-none bg-white">
                <option value="">Pilih rating</option>
                @foreach(range(5, 1) as $rating)
                    <option value="{{ $rating }}" @selected(old('Rating') == $rating)>{{ $rating }} bintang</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="foto_ulasan" class="block text-sm font-bold mb-1.5 bg-[#2878eb] text-white py-2 px-4 rounded-lg">
                Foto Ulasan (Opsional)
            </label>
            <input id="foto_ulasan" name="foto_ulasan" type="file" accept="image/*"
                class="w-full px-3 py-2.5 border border-[#dde1ea] rounded-lg outline-none">
        </div>

        <div>
            <label for="Ulasan" class="block text-sm font-bold mb-1.5">Ulasan</label>
            <textarea id="Ulasan" name="Ulasan" maxlength="250" required rows="4"
                      class="w-full px-3 py-2.5 border border-[#dde1ea] rounded-lg outline-none">{{ old('Ulasan') }}</textarea>
        </div>

        <button type="submit" class="w-full py-2.5 rounded-lg font-bold bg-[#2878eb] text-white">
            Kirim Ulasan
        </button>
    </form>
</div>
