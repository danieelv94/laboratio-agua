<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resultados de Análisis Listos</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; -webkit-font-smoothing: antialiased;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; padding: 20px 0;">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color: #691B31; padding: 40px 20px; border-bottom: 4px solid #BC955B;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">
                                Calidad del Agua - CEAA
                            </h1>
                            <p style="color: #DDC9A3; margin: 5px 0 0 0; font-size: 13px; font-weight: 600;">
                                Comisión Estatal del Agua y Alcantarillado
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px; background-color: #ffffff;">
                            <p style="font-size: 15px; line-height: 24px; color: #334155; margin: 0 0 20px 0;">
                                Estimado(a) <strong>{{ $studyRequest->solicitante }}</strong>,
                            </p>
                            <p style="font-size: 14px; line-height: 22px; color: #475569; margin: 0 0 24px 0;">
                                Nos complace informarle que el análisis de calidad de agua correspondiente a su folio <strong>{{ $studyRequest->referencia_bancaria }}</strong> ha sido concluido y los resultados se encuentran listos.
                            </p>
                            
                            <!-- Detail Box -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ecfdf5; border-radius: 12px; border: 1px solid #d1fae5; padding: 20px; margin-bottom: 24px;">
                                <tr>
                                    <td align="center" style="font-size: 14px; color: #065f46; font-weight: 600; line-height: 22px;">
                                        ¡Su Certificado Oficial de Resultados ya está disponible para descarga!
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="font-size: 13px; line-height: 20px; color: #64748b; margin: 0 0 30px 0;">
                                Al hacer clic en el botón de abajo, será dirigido a su portal de seguimiento. <strong>Importante:</strong> Para activar la descarga del certificado oficial, el sistema le solicitará responder una breve encuesta de satisfacción obligatoria sobre la atención y el servicio brindado.
                            </p>
                            
                            <!-- Button -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="https://laboratorio-agua.ceaa-hidalgo.com/solicitud/{{ $studyRequest->referencia_bancaria }}" 
                                           style="background-color: #691B31; border: 1px solid #691B31; border-radius: 12px; color: #ffffff; display: inline-block; font-size: 13px; font-weight: bold; line-height: 50px; text-align: center; text-decoration: none; width: 280px; -webkit-text-size-adjust: none; box-shadow: 0 4px 6px -1px rgba(105, 27, 49, 0.25);">
                                            DESCARGAR RESULTADOS
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f1f5f9; padding: 30px 20px; border-top: 1px solid #e2e8f0;">
                            <p style="color: #64748b; font-size: 11px; line-height: 18px; margin: 0 0 8px 0; text-align: center;">
                                Este es un correo automático generado por el Sistema de Calidad de Agua de la CEAA.<br>
                                Por favor no responda directamente a este correo.
                            </p>
                            <p style="color: #94a3b8; font-size: 11px; margin: 0; text-align: center;">
                                &copy; {{ date('Y') }} Dirección de Calidad del Agua. Todos los derechos reservados.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
