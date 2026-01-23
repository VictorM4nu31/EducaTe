<?php

namespace Database\Seeders;

use App\Models\SatLesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatLessonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessons = [
            [
                'title' => '¿Qué es el SAT?',
                'content' => '<h3>Introducción al SAT</h3>
                <p>El <strong>Servicio de Administración Tributaria (SAT)</strong> es un órgano desconcentrado de la Secretaría de Hacienda y Crédito Público (SHCP) de México. Su función principal es recaudar los impuestos que permiten al gobierno financiar servicios públicos como educación, salud, infraestructura y seguridad.</p>
                
                <h4>¿Por qué existen los impuestos?</h4>
                <p>Los impuestos son contribuciones obligatorias que los ciudadanos y empresas hacen al Estado. Estos recursos se utilizan para:</p>
                <ul>
                    <li>Construir y mantener carreteras, escuelas y hospitales</li>
                    <li>Pagar servicios públicos como agua, luz y seguridad</li>
                    <li>Apoyar programas sociales</li>
                    <li>Mantener la infraestructura del país</li>
                </ul>
                
                <h4>¿Qué hace el SAT?</h4>
                <p>El SAT se encarga de:</p>
                <ul>
                    <li>Recaudar impuestos (IVA, ISR, IEPS, etc.)</li>
                    <li>Emitir y administrar el RFC de personas y empresas</li>
                    <li>Vigilar el cumplimiento de obligaciones fiscales</li>
                    <li>Proporcionar información y servicios fiscales</li>
                </ul>',
                'category' => 'general',
                'order' => 1,
            ],
            [
                'title' => '¿Qué es el RFC y para qué sirve?',
                'content' => '<h3>Registro Federal de Contribuyentes (RFC)</h3>
                <p>El <strong>RFC</strong> es tu identificación fiscal única ante el SAT. Es como tu "cédula fiscal" que te identifica en todas tus actividades económicas.</p>
                
                <h4>Estructura del RFC</h4>
                <p>El RFC tiene 13 caracteres divididos en tres partes:</p>
                <ol>
                    <li><strong>Iniciales (4 caracteres):</strong> Provienen de tu nombre completo (apellidos y nombre)</li>
                    <li><strong>Fecha (6 dígitos):</strong> Tu fecha de nacimiento o registro en formato YYMMDD</li>
                    <li><strong>Homoclave (3 caracteres):</strong> Código único asignado por el SAT para evitar duplicados</li>
                </ol>
                
                <h4>¿Cuándo necesitas tu RFC?</h4>
                <ul>
                    <li>Al trabajar y recibir ingresos</li>
                    <li>Para abrir una cuenta bancaria</li>
                    <li>Al comprar o vender bienes</li>
                    <li>Para recibir facturas</li>
                    <li>Al realizar cualquier actividad económica formal</li>
                </ul>
                
                <h4>En AulaChain</h4>
                <p>Tu RFC simulado funciona igual que el real: es tu identificación única en el sistema. Lo usarás para transferencias P2P y aparecerá en tus facturas educativas.</p>',
                'category' => 'rfc',
                'order' => 1,
            ],
            [
                'title' => 'Tipos de Comprobantes Fiscales',
                'content' => '<h3>Comprobantes Fiscales Digitales</h3>
                <p>Los comprobantes fiscales son documentos que acreditan una operación comercial. En México, los principales tipos son:</p>
                
                <h4>Factura Electrónica (CFDI)</h4>
                <p>Es el comprobante más común. Debe incluir:</p>
                <ul>
                    <li>Datos del emisor (nombre, RFC, dirección)</li>
                    <li>Datos del receptor (nombre, RFC)</li>
                    <li>Concepto de la operación</li>
                    <li>Monto y desglose de impuestos</li>
                    <li>Folio fiscal único (UUID)</li>
                    <li>Código QR para verificación</li>
                </ul>
                
                <h4>Otros Comprobantes</h4>
                <ul>
                    <li><strong>Recibo de Honorarios:</strong> Para pagos por servicios profesionales</li>
                    <li><strong>Nota de Crédito:</strong> Para devoluciones o descuentos</li>
                    <li><strong>Nota de Débito:</strong> Para cargos adicionales</li>
                </ul>
                
                <h4>En AulaChain</h4>
                <p>Cuando canjeas una recompensa, recibes una "Factura Digital Educativa" que simula el formato real. Esto te ayuda a entender cómo funcionan los comprobantes fiscales en la vida real.</p>',
                'category' => 'invoices',
                'order' => 1,
            ],
            [
                'title' => '¿Por qué pagamos impuestos?',
                'content' => '<h3>La Importancia de los Impuestos</h3>
                <p>Los impuestos son la forma en que la sociedad financia los servicios públicos que todos necesitamos.</p>
                
                <h4>Principios de los Impuestos</h4>
                <ul>
                    <li><strong>Proporcionalidad:</strong> Quien gana más, paga más</li>
                    <li><strong>Legalidad:</strong> Solo se pueden cobrar impuestos establecidos por ley</li>
                    <li><strong>Transparencia:</strong> Los ciudadanos deben saber en qué se usan los impuestos</li>
                </ul>
                
                <h4>¿A dónde van tus impuestos?</h4>
                <p>Los recursos recaudados se destinan a:</p>
                <ul>
                    <li><strong>Educación:</strong> Escuelas públicas, becas, programas educativos</li>
                    <li><strong>Salud:</strong> Hospitales, clínicas, medicamentos</li>
                    <li><strong>Infraestructura:</strong> Carreteras, puentes, transporte público</li>
                    <li><strong>Seguridad:</strong> Policía, bomberos, protección civil</li>
                    <li><strong>Programas Sociales:</strong> Apoyo a personas vulnerables</li>
                </ul>
                
                <h4>En AulaChain</h4>
                <p>El 5% de cada AulaChain que ganas va al "Fondo Común de la Clase", similar a los impuestos reales. Este fondo se usa para premios grupales y eventos especiales, enseñándote el concepto de contribución colectiva.</p>',
                'category' => 'taxes',
                'order' => 1,
            ],
            [
                'title' => 'Cultura de Legalidad Fiscal',
                'content' => '<h3>Ser un Contribuyente Responsable</h3>
                <p>La cultura de legalidad fiscal significa cumplir voluntariamente con tus obligaciones fiscales, no solo por temor a sanciones, sino por convicción de que es lo correcto.</p>
                
                <h4>Principios de un Buen Contribuyente</h4>
                <ul>
                    <li><strong>Honestidad:</strong> Declarar correctamente tus ingresos</li>
                    <li><strong>Puntualidad:</strong> Pagar impuestos en tiempo y forma</li>
                    <li><strong>Transparencia:</strong> Mantener registros claros de tus operaciones</li>
                    <li><strong>Responsabilidad:</strong> Entender que los impuestos benefician a todos</li>
                </ul>
                
                <h4>Beneficios de Cumplir</h4>
                <ul>
                    <li>Acceso a créditos y servicios financieros</li>
                    <li>Posibilidad de facturar y recibir facturas</li>
                    <li>Construcción de historial crediticio</li>
                    <li>Contribución al bienestar social</li>
                </ul>
                
                <h4>En AulaChain</h4>
                <p>Al ser un "contribuyente responsable" en AulaChain (ahorrando, cumpliendo con tareas, usando el sistema correctamente), recibes reconocimientos y beneficios, igual que en la vida real.</p>',
                'category' => 'general',
                'order' => 2,
            ],
        ];

        foreach ($lessons as $lesson) {
            SatLesson::create($lesson);
        }
    }
}
