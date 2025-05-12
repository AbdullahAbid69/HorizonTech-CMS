@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Edit Alumni Event</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form style="width: 100%" action="{{ route('admin.alumni_events.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-6">
                        <label for="title">Event Title</label>
                        <input class="form-control" value="{{ old('title', $event->title) }}" type="text" name="title" id="title">
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                        <label for="venue">Venue</label>
                        <input class="form-control" value="{{ old('venue', $event->venue) }}" type="text" name="venue" id="venue">
                        @error('venue')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="organizer_name">Organizer Name</label>
                        <input class="form-control" value="{{ old('organizer_name', $event->organizer_name) }}" type="text" name="organizer_name" id="organizer_name">
                        @error('organizer_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="event_date">Event Date</label>
                        <input class="form-control" value="{{ old('event_date', $event->event_date) }}" type="date" name="event_date" id="event_date">
                        @error('event_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="event_time">Event Time</label>
                        <input class="form-control" value="{{ old('event_time', $event->event_time) }}" type="time" name="event_time" id="event_time">
                        @error('event_time')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="fee">Fee</label>
                        <input class="form-control" value="{{ old('fee', $event->fee) }}" type="number" name="fee" id="fee" step="0.01" min="0">
                        @error('fee')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="contact_email">Contact Email</label>
                        <input class="form-control" value="{{ old('contact_email', $event->contact_email) }}" type="email" name="contact_email" id="contact_email">
                        @error('contact_email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="contact_phone">Contact Phone</label>
                        <input class="form-control" value="{{ old('contact_phone', $event->contact_phone) }}" type="text" name="contact_phone" id="contact_phone">
                        @error('contact_phone')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">Select Status</option>
                            <option value="upcoming" {{ old('status', $event->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-12 mt-3">
                        <label for="description">Description (optional)</label>
                        <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4 d-flex justify-content-start">
                    <div class="col-2">
                        <input type="submit" value="Update" class="btn btn-md btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
