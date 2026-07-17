@extends('layouts.app')

@section('title', 'Kelola Jadwal Dokter')
@section('page-title', 'Jadwal: ' . $doctor->name)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background-color: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-right: 20px;">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">{{ $doctor->name }}</h4>
                        <span class="badge bg-primary">{{ $doctor->department->name ?? 'Poli Umum' }}</span>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-calendar-week text-success me-2"></i>Jadwal Praktik</h5>
                        <p class="text-muted small mt-1">Tambahkan hari dan jam praktik dokter untuk poliklinik.</p>
                    </div>
                    <button type="button" class="btn btn-sm btn-success" onclick="addScheduleRow()">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Jadwal
                    </button>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('doctors.storeSchedules', $doctor->id) }}" method="POST">
                        @csrf
                        
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle" id="scheduleTable">
                                <thead class="border-bottom">
                                    <tr>
                                        <th style="width: 30%">Hari</th>
                                        <th style="width: 30%">Jam Mulai</th>
                                        <th style="width: 30%">Jam Selesai</th>
                                        <th style="width: 10%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schedules as $index => $schedule)
                                    <tr class="schedule-row">
                                        <td>
                                            <select name="schedules[{{ $index }}][day_of_week]" class="form-select" required>
                                                <option value="1" {{ $schedule->day_of_week == 1 ? 'selected' : '' }}>Senin</option>
                                                <option value="2" {{ $schedule->day_of_week == 2 ? 'selected' : '' }}>Selasa</option>
                                                <option value="3" {{ $schedule->day_of_week == 3 ? 'selected' : '' }}>Rabu</option>
                                                <option value="4" {{ $schedule->day_of_week == 4 ? 'selected' : '' }}>Kamis</option>
                                                <option value="5" {{ $schedule->day_of_week == 5 ? 'selected' : '' }}>Jumat</option>
                                                <option value="6" {{ $schedule->day_of_week == 6 ? 'selected' : '' }}>Sabtu</option>
                                                <option value="7" {{ $schedule->day_of_week == 7 ? 'selected' : '' }}>Minggu</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="time" name="schedules[{{ $index }}][start_time]" class="form-control" value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}" required>
                                        </td>
                                        <td>
                                            <input type="time" name="schedules[{{ $index }}][end_time]" class="form-control" value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}" required>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr id="emptyRow">
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada jadwal. Silakan klik "Tambah Jadwal".</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let scheduleIndex = {{ count($schedules) }};

    function addScheduleRow() {
        const tableBody = document.querySelector('#scheduleTable tbody');
        const emptyRow = document.getElementById('emptyRow');
        
        if (emptyRow) {
            emptyRow.remove();
        }

        const tr = document.createElement('tr');
        tr.className = 'schedule-row';
        tr.innerHTML = `
            <td>
                <select name="schedules[${scheduleIndex}][day_of_week]" class="form-select" required>
                    <option value="1">Senin</option>
                    <option value="2">Selasa</option>
                    <option value="3">Rabu</option>
                    <option value="4">Kamis</option>
                    <option value="5">Jumat</option>
                    <option value="6">Sabtu</option>
                    <option value="7">Minggu</option>
                </select>
            </td>
            <td>
                <input type="time" name="schedules[${scheduleIndex}][start_time]" class="form-control" value="08:00" required>
            </td>
            <td>
                <input type="time" name="schedules[${scheduleIndex}][end_time]" class="form-control" value="12:00" required>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="bi bi-trash"></i></button>
            </td>
        `;
        tableBody.appendChild(tr);
        scheduleIndex++;
    }

    function removeRow(btn) {
        btn.closest('tr').remove();
    }
</script>
@endsection
