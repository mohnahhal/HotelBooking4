<form id="booking-form">
    @csrf
    
    <div class="mb-3">
        <label>الغرفة</label>
        <select class="form-control" id="room_id" required>
            <option value="">اختر غرفة</option>
            @foreach($rooms as $room)
            @auth
                <option value="{{ $room->id }}">
                    غرفة {{ $room->room_number }} 
                </option>
                @endauth
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>تاريخ الوصول</label>
        <input type="date" class="form-control" id="check_in" 
               min="{{ date('Y-m-d') }}" required>
    </div>

    <div class="mb-3">
        <label>تاريخ المغادرة</label>
        <input type="date" class="form-control" id="check_out" required>
    </div>

    <button type="button" onclick="checkAvailability()" class="btn btn-primary">
        تحقق من التوفر
    </button>

    <div id="availability-result" class="mt-3" style="display:none;"></div>
</form>

<script>
function checkAvailability() {
    let roomId = $('#room_id').val();
    let checkIn = $('#check_in').val();
    let checkOut = $('#check_out').val();

    if (!roomId || !checkIn || !checkOut) {
        alert('الرجاء ملء جميع الحقول');
        return;
    }

    $.ajax({
        url: '/check-availability',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            room_id: roomId,
            check_in: checkIn,
            check_out: checkOut
        },
        success: function(response) {
            let resultDiv = $('#availability-result');
            resultDiv.show();
            
            if (response.available) {
                resultDiv.html(`
                    <div class="alert alert-success">
                        ✓ متاحة! <br>
                        ${response.nights} ليالي <br>
                        السعر الكلي: $${response.total_price}
                    </div>
                `);
            } else {
                resultDiv.html(`
                    <div class="alert alert-danger">
                        ✗ غير متاحة: ${response.message}
                    </div>
                `);
            }
        }
    });
}
</script>