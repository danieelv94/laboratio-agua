<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:w="urn:schemas-microsoft-com:office:word"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--[if gte mso 9]>
    <xml>
        <w:WordDocument>
            <w:View>Print</w:View>
            <w:Zoom>100</w:Zoom>
            <w:DoNotOptimizeForBrowser/>
        </w:WordDocument>
    </xml>
    <![endif]-->
    <style>
        @page {
            size: 21.59cm 27.94cm;
            margin: 1.5cm 1.5cm 1.5cm 1.5cm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
            color: #000000;
        }
        table.survey-table {
            width: 100%;
            border-collapse: collapse;
            border: 1.5pt solid #000000;
            margin-bottom: 18pt;
        }
        table.survey-table td, table.survey-table th {
            border: 1pt solid #000000;
            padding: 4pt 6pt;
            vertical-align: middle;
            font-size: 8.5pt;
        }
        .header-title {
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
        }
        .section-bar {
            background-color: #D9D9D9;
            font-weight: bold;
            text-align: center;
            font-size: 9pt;
            text-transform: uppercase;
        }
        .center {
            text-align: center;
        }
        .bold {
            font-weight: bold;
        }
        .score-selected {
            font-weight: bold;
            background-color: #EFEFEF;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
@php
    $logoPath = public_path('images/encabezado.png');
    $logoBase64 = '';
    if (file_exists($logoPath)) {
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
    }

    $officialQuestions = [
        1 => '1. Facilidad para acceder al servicio:',
        2 => '2. ¿Se le atendió en el tiempo prometido?',
        3 => '3. ¿Se cumplieron los requerimientos técnicos del servicio?',
        4 => '4. ¿Usted recibió un trato amable del personal que lo atendió?',
        5 => '5. ¿Cómo considera la competencia del personal inspector que lo atendió?',
        6 => '6. ¿Cómo evaluaría la calidad del trabajo realizado durante la inspección?',
        7 => '7. ¿Los métodos de inspección utilizados son adecuados a sus necesidades?',
        8 => '8. ¿Cómo calificaría la calidad de la atención recibida?',
        9 => '9. En general el servicio recibido por el Laboratorio CEAA fue:',
        10 => '10. ¿Nos recomendaría?',
    ];

    $questionsToRender = isset($selectedQuestion) && isset($officialQuestions[$selectedQuestion])
        ? [$selectedQuestion => $officialQuestions[$selectedQuestion]]
        : $officialQuestions;
@endphp

@foreach($surveys as $index => $survey)
    <table class="survey-table">
        <!-- Row 1-3: Header with Logo and Document Control -->
        <tr>
            <td rowspan="3" colspan="3" class="center" style="width: 48%; padding: 6pt;">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" width="250" height="72" alt="CEAA Hidalgo" style="max-width: 250px; height: auto;">
                @else
                    <strong>CEAA - COMISIÓN ESTATAL DEL AGUA Y ALCANTARILLADO</strong>
                @endif
            </td>
            <td colspan="5" class="header-title" style="width: 52%;">
                ENCUESTA DE SATISFACCIÓN
            </td>
        </tr>
        <tr>
            <td colspan="2" class="center bold">Vigente a partir de:</td>
            <td colspan="2" class="center bold">CODIFICACIÓN</td>
            <td colspan="1" class="center bold">Revisión:</td>
        </tr>
        <tr>
            <td colspan="2" class="center">24-03-2025</td>
            <td colspan="2" class="center">FC-SG-LCH2O/11</td>
            <td colspan="1" class="center">01</td>
        </tr>

        <!-- Section: DATOS DEL CLIENTE -->
        <tr>
            <td colspan="8" class="section-bar">DATOS DEL CLIENTE</td>
        </tr>
        <tr>
            <td class="bold" style="width: 18%;">Nombre del cliente:</td>
            <td colspan="2" style="width: 30%;">{{ $survey->solicitante }} @if($survey->representante) ({{ $survey->representante }}) @endif</td>
            <td class="bold" style="width: 14%;">Domicilio:</td>
            <td colspan="4" style="width: 38%;">{{ $survey->direccion }}</td>
        </tr>
        <tr>
            <td class="bold">Número de informe:</td>
            <td colspan="2">{{ $survey->referencia_bancaria }}</td>
            <td class="bold">Correo electrónico y teléfono:</td>
            <td colspan="4">{{ $survey->email }}@if($survey->telefono) / {{ $survey->telefono }}@endif</td>
        </tr>

        <!-- Section: CUESTIONARIO -->
        <tr>
            <td colspan="8" class="section-bar">CUESTIONARIO</td>
        </tr>
        <tr>
            <td colspan="8"><span class="bold">FECHA:</span> {{ $survey->updated_at ? $survey->updated_at->format('d/m/Y H:i') : '' }}</td>
        </tr>
        <tr>
            <td colspan="3" class="bold">
                Conteste las siguientes preguntas colocando una equis (X) de acuerdo con los criterios indicados:
            </td>
            <td class="center bold" style="width: 10%;">Excelente</td>
            <td class="center bold" style="width: 10%;">Bueno</td>
            <td class="center bold" style="width: 10%;">Regular</td>
            <td class="center bold" style="width: 10%;">Malo</td>
            <td class="center bold" style="width: 10%;">Muy malo</td>
        </tr>

        @foreach($questionsToRender as $num => $qText)
            @php
                $val = (int) ($survey->{"encuesta_p{$num}"} ?? 0);
            @endphp
            <tr>
                <td colspan="3">{{ $qText }}</td>
                @foreach([5, 4, 3, 2, 1] as $score)
                    <td class="center {{ $val === $score ? 'score-selected' : '' }}">
                        @if($val === $score)
                            <strong>X ({{ $score }})</strong>
                        @else
                            {{ $score }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach

        <!-- Promedio -->
        <tr>
            <td colspan="8">
                <span class="bold">Promedio:</span>
                <span style="text-decoration: underline; font-weight: bold;">&nbsp;&nbsp;{{ number_format( isset($selectedQuestion) ? ($survey->{"encuesta_p{$selectedQuestion}"} ?? 0) : ($survey->encuesta_promedio ?? 0), 2 ) }}&nbsp;&nbsp;</span>
                (para uso exclusivo del encuestador)
            </td>
        </tr>

        <!-- Open Feedback -->
        <tr>
            <td colspan="3" class="bold">¿Qué recomendaría para mejorarnos?</td>
            <td colspan="5">{{ $survey->encuesta_mejoras ?: 'Sin comentarios.' }}</td>
        </tr>
        <tr>
            <td colspan="3" class="bold">Comentarios adicionales:</td>
            <td colspan="5">{{ $survey->encuesta_comentarios ?: 'Sin comentarios.' }}</td>
        </tr>
        <tr>
            <td colspan="8" class="center bold" style="padding: 6pt;">
                Gracias por tomarse el tiempo para completar la encuesta.
            </td>
        </tr>
    </table>

    @if(!$loop->last)
        <br clear="all" style="page-break-before: always; mso-break-type: section-break;" />
    @endif
@endforeach
</body>
</html>
