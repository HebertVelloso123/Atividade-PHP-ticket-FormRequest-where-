@extends('layouts.app')

@section('title', $evento->titulo . ' — FalaQ')

@section('content')
<div class="row">
    <!-- Formularço de envio de Pergunta -->
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm p-3">
            <h4 class="fw-bold mb-3">💬 Faça sua Pergunta</h4>
            <form action="{{ route('eventos.perguntas.store', $evento->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="texto" class="form-label text-secondary">Texto da Pergunta</label>

                    <textarea name="texto" id="texto" rows="4" 
                              class="form-control bg-dark text-white border-secondary @error('texto') is-invalid @enderror"
                              placeholder="Digite sua dúvida ou comentário para o palestrante..."></textarea>

                    @error('texto')
                        <div class="invalid-feedback fw-bold">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Enviar Pergunta</button>
            </form>
        </div>
    </div>

    <!-- Lista de Perguntas (TICKET #002) -->
    <div class="col-md-7">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold m-0">📋 Perguntas do Evento</h4>
            <span class="text-secondary small">Total no Banco: {{ $evento->perguntas->count() }}</span>
        </div>

        @forelse($perguntas as $pergunta)
            <div class="card mb-3 shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <p class="fs-5 mb-2 text-white">{{ $pergunta->texto }}</p>
                    <div class="d-flex justify-content-between align-items-center text-secondary small">
                        <span>Status: <span class="badge bg-success">{{ $pergunta->status }}</span></span>
                        <span>{{ $pergunta->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-dark text-center p-4">
                Nenhuma pergunta enviada ainda. Seja o primeiro!
            </div>
        @endforelse

        <!-- TICKET #002: Renderização dos Botões de Paginação -->
        @if(method_exists($perguntas, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $perguntas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

  <!-- sprint 04 -->
  <form action="{{ route('perguntas.store', $evento->id) }}" method="POST" class="mb-8">
    @csrf

    <div class="mb-4">
        <label for="conteudo" class="block text-sm font-medium text-gray-700 mb-1">
            Faça sua pergunta
        </label>
        
        <textarea 
            name="conteudo" 
            id="conteudo" 
            rows="3" 
            placeholder="Digite sua pergunta aqui..."
            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 transition-colors @error('conteudo') border-red-500 focus:ring-red-200 @else border-gray-300 focus:ring-blue-200 focus:border-blue-500 @enderror"
        >{{ old('conteudo') }}</textarea>

        @error('conteudo')
            <p class="text-red-500 text-sm mt-1 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <button 
        type="submit" 
        class="bg-blue-600 text-white font-semibold px-5 py-2.5 rounded-md hover:bg-blue-700 active:bg-blue-800 transition-colors duration-150 shadow-sm"
    >
        Enviar Pergunta
    </button>
</form>


<div class="space-y-4">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Perguntas do Evento</h2>

    @forelse($evento->perguntas as $pergunta)
        {{-- Card da pergunta --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-4">
            <p class="text-gray-800 text-base leading-relaxed mb-2">
                {{ $pergunta->conteudo }}
            </p>
            <div class="flex items-center justify-between text-xs text-gray-500">
                <span>Enviado {{ $pergunta->created_at->diffForHumans() }}</span>
            </div>
        </div>
    @empty
        <p class="text-gray-500 italic">Nenhuma pergunta enviada ainda. Seja o primeiro a perguntar!</p>
    @endforelse
</div>