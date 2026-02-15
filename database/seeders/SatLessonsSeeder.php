<?php

namespace Database\Seeders;

use App\Models\SatLesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SatLessonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessons = [
            // ============================================
            // CATEGORÍA: GENERAL
            // ============================================
            [
                'title' => '¿Qué es el SAT?',
                'slug' => Str::slug('¿Qué es el SAT?'),
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
                'category' => SatLesson::CATEGORY_GENERAL,
                'difficulty' => SatLesson::DIFFICULTY_BASIC,
                'estimated_minutes' => 5,
                'category_order' => 1,
                'lesson_order' => 1,
                'order' => 1,
            ],
            [
                'title' => 'Cultura de Legalidad Fiscal',
                'slug' => Str::slug('Cultura de Legalidad Fiscal'),
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
                'category' => SatLesson::CATEGORY_GENERAL,
                'difficulty' => SatLesson::DIFFICULTY_BASIC,
                'estimated_minutes' => 6,
                'category_order' => 2,
                'lesson_order' => 2,
                'order' => 2,
            ],

            // ============================================
            // CATEGORÍA: RFC
            // ============================================
            [
                'title' => '¿Qué es el RFC y para qué sirve?',
                'slug' => Str::slug('¿Qué es el RFC y para qué sirve?'),
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
                'category' => SatLesson::CATEGORY_RFC,
                'difficulty' => SatLesson::DIFFICULTY_BASIC,
                'estimated_minutes' => 7,
                'category_order' => 1,
                'lesson_order' => 3,
                'order' => 3,
            ],

            // ============================================
            // CATEGORÍA: REGÍMENES FISCALES (NUEVO)
            // ============================================
            [
                'title' => '¿Qué es un Régimen Fiscal?',
                'slug' => Str::slug('¿Qué es un Régimen Fiscal?'),
                'content' => '<h3>Regímenes Fiscales en México</h3>
                <p>Un <strong>régimen fiscal</strong> es el conjunto de derechos y obligaciones que tienes ante el SAT según tu tipo de actividad económica. Determina cómo calculas y pagas tus impuestos.</p>
                
                <h4>Persona Física vs Persona Moral</h4>
                <p><strong>Persona Física:</strong> Eres tú como individuo. Trabajas, prestas servicios o tienes un negocio a tu nombre.</p>
                <p><strong>Persona Moral:</strong> Es una empresa o sociedad (S.A., S. de R.L., etc.). Tiene personalidad jurídica propia, separada de sus socios.</p>
                
                <h4>Principales Regímenes para Personas Físicas</h4>
                <ul>
                    <li><strong>Sueldos y Salarios:</strong> Si trabajas para alguien más y recibes nómina. Tu patrón retiene y paga tus impuestos.</li>
                    <li><strong>RESICO (Régimen Simplificado de Confianza):</strong> Para pequeños negocios con ingresos menores a $3.5 millones al año. Tasas reducidas y trámites simplificados.</li>
                    <li><strong>Actividad Empresarial y Profesional:</strong> Para negocios más grandes o profesionistas independientes (abogados, médicos, consultores).</li>
                    <li><strong>Arrendamiento:</strong> Si rentas propiedades.</li>
                    <li><strong>Incorporación Fiscal (en transición):</strong> Régimen anterior al RESICO, aún vigente para algunos contribuyentes.</li>
                </ul>
                
                <h4>Ejemplos Reales</h4>
                <p><strong>Ejemplo 1 - Sueldos y Salarios:</strong><br>
                María trabaja en una oficina. Gana $15,000 al mes. Su empresa le descuenta ISR e IMSS de su nómina. Ella no presenta declaraciones mensuales, solo la anual.</p>
                
                <p><strong>Ejemplo 2 - RESICO:</strong><br>
                Juan tiene una taquería. Vende $80,000 al mes. Está en RESICO porque no rebasa $3.5 millones anuales. Paga ISR del 1% al 2.5% según sus ingresos y presenta declaraciones bimestrales.</p>
                
                <p><strong>Ejemplo 3 - Actividad Empresarial:</strong><br>
                Laura es diseñadora freelance. Factura $150,000 al mes a diferentes clientes. Está en Actividad Empresarial, paga ISR e IVA mensualmente.</p>
                
                <h4>Obligaciones según Régimen</h4>
                <table border="1" cellpadding="8" style="border-collapse: collapse; width: 100%;">
                    <tr>
                        <th>Régimen</th>
                        <th>Declaraciones</th>
                        <th>Facturación</th>
                        <th>Contabilidad</th>
                    </tr>
                    <tr>
                        <td>Sueldos y Salarios</td>
                        <td>Solo anual</td>
                        <td>No aplica</td>
                        <td>No requerida</td>
                    </tr>
                    <tr>
                        <td>RESICO</td>
                        <td>Bimestral</td>
                        <td>Obligatoria</td>
                        <td>Simplificada</td>
                    </tr>
                    <tr>
                        <td>Actividad Empresarial</td>
                        <td>Mensual + Anual</td>
                        <td>Obligatoria</td>
                        <td>Completa</td>
                    </tr>
                </table>
                
                <h4>¿Cómo elegir tu régimen?</h4>
                <p>Depende de:</p>
                <ul>
                    <li>Tipo de actividad que realizas</li>
                    <li>Nivel de ingresos anuales</li>
                    <li>Si trabajas por tu cuenta o para alguien más</li>
                    <li>Capacidad administrativa (llevar contabilidad)</li>
                </ul>
                
                <h4>En AulaChain</h4>
                <p>Aunque en AulaChain no elegimos régimen, entender estos conceptos te prepara para cuando tengas que inscribirte en el SAT real. Simularemos algunos aspectos como la facturación y las "declaraciones" educativas.</p>',
                'category' => SatLesson::CATEGORY_REGIMES,
                'difficulty' => SatLesson::DIFFICULTY_INTERMEDIATE,
                'estimated_minutes' => 12,
                'category_order' => 1,
                'lesson_order' => 4,
                'order' => 4,
            ],

            // ============================================
            // CATEGORÍA: IMPUESTOS (AMPLIADO)
            // ============================================
            [
                'title' => '¿Por qué pagamos impuestos?',
                'slug' => Str::slug('¿Por qué pagamos impuestos?'),
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
                'category' => SatLesson::CATEGORY_TAXES,
                'difficulty' => SatLesson::DIFFICULTY_BASIC,
                'estimated_minutes' => 5,
                'category_order' => 1,
                'lesson_order' => 5,
                'order' => 5,
            ],
            [
                'title' => 'Principales Impuestos en México',
                'slug' => Str::slug('Principales Impuestos en México'),
                'content' => '<h3>Los Tres Impuestos Principales</h3>
                <p>En México, los impuestos más importantes que debes conocer son: ISR, IVA e IEPS. Cada uno funciona de manera diferente.</p>
                
                <h4>ISR - Impuesto Sobre la Renta</h4>
                <p>El ISR grava tus <strong>ingresos</strong>. Es decir, pagas un porcentaje de lo que ganas.</p>
                
                <p><strong>Características:</strong></p>
                <ul>
                    <li>Es <strong>progresivo</strong>: quien gana más, paga un porcentaje mayor</li>
                    <li>Se calcula sobre tus ganancias netas (ingresos menos gastos deducibles)</li>
                    <li>Varía según tu régimen fiscal</li>
                </ul>
                
                <p><strong>Ejemplo Práctico - Persona Física con Actividad Empresarial:</strong></p>
                <div style="background: #f5f5f5; padding: 15px; border-left: 4px solid #2196F3; margin: 10px 0;">
                    <p><strong>Caso de Laura (Diseñadora Freelance):</strong></p>
                    <p>Ingresos del mes: $50,000<br>
                    Gastos deducibles (equipo, internet, renta de oficina): $15,000<br>
                    <strong>Base gravable:</strong> $50,000 - $15,000 = $35,000</p>
                    <p>Según la tabla del ISR, sobre $35,000 mensuales pagaría aproximadamente $5,500 de ISR (tasa efectiva ~15.7%)</p>
                </div>
                
                <p><strong>Tasas de ISR para Personas Físicas (2024):</strong></p>
                <ul>
                    <li>Hasta $7,735 mensuales: 1.92%</li>
                    <li>De $7,735 a $65,651: 6.4% a 30%</li>
                    <li>Más de $65,651: 30% a 35%</li>
                </ul>
                
                <h4>IVA - Impuesto al Valor Agregado</h4>
                <p>El IVA grava el <strong>consumo</strong>. Se aplica cuando compras o vendes productos y servicios.</p>
                
                <p><strong>Características:</strong></p>
                <ul>
                    <li>Tasa general: <strong>16%</strong></li>
                    <li>Tasa fronteriza: 8% (en zonas fronterizas)</li>
                    <li>Tasa 0%: Alimentos básicos, medicinas, exportaciones</li>
                    <li>Exentos: Servicios educativos, médicos, renta de casa habitación</li>
                </ul>
                
                <p><strong>Conceptos Clave:</strong></p>
                <ul>
                    <li><strong>IVA Trasladado:</strong> El que cobras a tus clientes</li>
                    <li><strong>IVA Acreditable:</strong> El que pagas a tus proveedores</li>
                    <li><strong>IVA a Pagar:</strong> Trasladado menos Acreditable</li>
                </ul>
                
                <p><strong>Ejemplo Práctico con Factura:</strong></p>
                <div style="background: #f5f5f5; padding: 15px; border-left: 4px solid #4CAF50; margin: 10px 0;">
                    <p><strong>Factura de Juan (Taquería):</strong></p>
                    <p style="font-family: monospace;">
                    5 Tacos al pastor ............ $50.00<br>
                    2 Refrescos .................. $30.00<br>
                    ─────────────────────────────────────<br>
                    Subtotal ..................... $80.00<br>
                    IVA (16%) .................... $12.80<br>
                    ─────────────────────────────────────<br>
                    <strong>Total ....................... $92.80</strong>
                    </p>
                    <p><strong>Del lado de Juan:</strong><br>
                    - Cobró $12.80 de IVA (IVA Trasladado)<br>
                    - Pagó $5.00 de IVA al comprar tortillas (IVA Acreditable)<br>
                    - IVA a pagar al SAT: $12.80 - $5.00 = <strong>$7.80</strong></p>
                </div>
                
                <h4>IEPS - Impuesto Especial sobre Producción y Servicios</h4>
                <p>El IEPS es un impuesto <strong>adicional</strong> que se aplica a productos específicos, generalmente para desincentivar su consumo o porque generan costos sociales.</p>
                
                <p><strong>Productos gravados con IEPS:</strong></p>
                <ul>
                    <li><strong>Bebidas alcohólicas:</strong> 25% a 53% según graduación</li>
                    <li><strong>Cigarros y tabacos:</strong> 160% + cuota fija</li>
                    <li><strong>Bebidas azucaradas:</strong> $1.27 por litro</li>
                    <li><strong>Combustibles:</strong> Cuota variable (gasolina, diésel)</li>
                    <li><strong>Alimentos con alta densidad calórica:</strong> 8%</li>
                </ul>
                
                <p><strong>Ejemplo Práctico:</strong></p>
                <div style="background: #f5f5f5; padding: 15px; border-left: 4px solid #FF9800; margin: 10px 0;">
                    <p><strong>Compra de refresco de 2 litros:</strong></p>
                    <p>Precio base ................. $20.00<br>
                    IEPS ($1.27 × 2 litros) ...... $2.54<br>
                    Subtotal ..................... $22.54<br>
                    IVA (16% sobre subtotal) ..... $3.61<br>
                    ─────────────────────────────────────<br>
                    <strong>Total ....................... $26.15</strong></p>
                    <p>Nota: El IEPS se calcula primero, luego el IVA se aplica sobre el precio ya con IEPS incluido.</p>
                </div>
                
                <h4>Comparación Rápida</h4>
                <table border="1" cellpadding="8" style="border-collapse: collapse; width: 100%;">
                    <tr>
                        <th>Impuesto</th>
                        <th>¿Qué grava?</th>
                        <th>¿Quién lo paga?</th>
                        <th>Tasa/Cuota</th>
                    </tr>
                    <tr>
                        <td>ISR</td>
                        <td>Ingresos/Ganancias</td>
                        <td>Personas y empresas</td>
                        <td>Progresiva 1.92% - 35%</td>
                    </tr>
                    <tr>
                        <td>IVA</td>
                        <td>Consumo</td>
                        <td>Consumidor final</td>
                        <td>16% (general)</td>
                    </tr>
                    <tr>
                        <td>IEPS</td>
                        <td>Productos específicos</td>
                        <td>Consumidor final</td>
                        <td>Variable según producto</td>
                    </tr>
                </table>
                
                <h4>En AulaChain</h4>
                <p>Cuando canjeas recompensas, verás en tu factura educativa cómo se desglosan estos conceptos. Esto te ayuda a entender cómo leer una factura real y comprender qué parte del precio son impuestos.</p>',
                'category' => SatLesson::CATEGORY_TAXES,
                'difficulty' => SatLesson::DIFFICULTY_INTERMEDIATE,
                'estimated_minutes' => 15,
                'category_order' => 2,
                'lesson_order' => 6,
                'order' => 6,
            ],

            // ============================================
            // CATEGORÍA: DECLARACIONES (NUEVO)
            // ============================================
            [
                'title' => '¿Qué es una Declaración Fiscal?',
                'slug' => Str::slug('¿Qué es una Declaración Fiscal?'),
                'content' => '<h3>Declaraciones Fiscales</h3>
                <p>Una <strong>declaración fiscal</strong> es el documento oficial donde informas al SAT cuánto ganaste, cuánto gastaste y cuánto impuesto debes pagar en un periodo determinado.</p>
                
                <h4>Tipos de Declaraciones</h4>
                
                <p><strong>1. Declaración Mensual (o Bimestral)</strong></p>
                <ul>
                    <li>Se presenta cada mes (o cada dos meses en RESICO)</li>
                    <li>Incluye ISR e IVA del periodo</li>
                    <li>Plazo: día 17 del mes siguiente</li>
                    <li>Ejemplo: La declaración de enero se presenta antes del 17 de febrero</li>
                </ul>
                
                <p><strong>2. Declaración Anual</strong></p>
                <ul>
                    <li>Resume todo el año fiscal (enero a diciembre)</li>
                    <li>Plazo para personas físicas: abril del año siguiente</li>
                    <li>Plazo para personas morales: marzo del año siguiente</li>
                    <li>Aquí puedes aplicar deducciones personales (gastos médicos, colegiaturas, etc.)</li>
                    <li>Puedes obtener saldo a favor (devolución de impuestos)</li>
                </ul>
                
                <h4>¿Qué incluye una declaración?</h4>
                <ul>
                    <li><strong>Ingresos:</strong> Todo lo que ganaste en el periodo</li>
                    <li><strong>Deducciones:</strong> Gastos permitidos por la ley que reducen tu base gravable</li>
                    <li><strong>Retenciones:</strong> Impuestos que ya te descontaron (si aplica)</li>
                    <li><strong>Impuesto a cargo:</strong> Lo que debes pagar</li>
                    <li><strong>Saldo a favor:</strong> Lo que el SAT te debe devolver (si pagaste de más)</li>
                </ul>
                
                <h4>Ejemplo Práctico - Declaración Mensual</h4>
                <div style="background: #f5f5f5; padding: 15px; border-left: 4px solid #2196F3; margin: 10px 0;">
                    <p><strong>Laura - Diseñadora Freelance (Marzo 2024):</strong></p>
                    <p>
                    Ingresos facturados .............. $120,000<br>
                    Gastos deducibles ................ $35,000<br>
                    ─────────────────────────────────────────────<br>
                    Base gravable .................... $85,000<br>
                    ISR a pagar (aprox. 20%) ......... $17,000<br>
                    <br>
                    IVA cobrado a clientes ........... $19,200<br>
                    IVA pagado a proveedores ......... $5,600<br>
                    ─────────────────────────────────────────────<br>
                    IVA a pagar ...................... $13,600<br>
                    <br>
                    <strong>Total a pagar al SAT: $30,600</strong><br>
                    Fecha límite: 17 de abril
                    </p>
                </div>
                
                <h4>Ejemplo Práctico - Declaración Anual</h4>
                <div style="background: #f5f5f5; padding: 15px; border-left: 4px solid #4CAF50; margin: 10px 0;">
                    <p><strong>Carlos - Empleado (Año 2023):</strong></p>
                    <p>
                    Ingresos anuales ................. $360,000<br>
                    ISR retenido por el patrón ....... $45,000<br>
                    <br>
                    <strong>Deducciones personales:</strong><br>
                    - Gastos médicos ................. $12,000<br>
                    - Colegiaturas ................... $18,000<br>
                    - Intereses hipotecarios ......... $25,000<br>
                    ─────────────────────────────────────────────<br>
                    Total deducciones ................ $55,000<br>
                    <br>
                    Base gravable ajustada ........... $305,000<br>
                    ISR que debió pagar .............. $42,000<br>
                    ISR ya pagado .................... $45,000<br>
                    ─────────────────────────────────────────────<br>
                    <strong>Saldo a favor: $3,000</strong> (el SAT le devuelve dinero)
                    </p>
                </div>
                
                <h4>¿Qué pasa si no declaras?</h4>
                <p>No presentar declaraciones tiene consecuencias graves:</p>
                <ul>
                    <li><strong>Multas:</strong> Desde $1,810 hasta $36,200 por cada declaración no presentada</li>
                    <li><strong>Recargos:</strong> Intereses moratorios que se acumulan mensualmente</li>
                    <li><strong>Actualizaciones:</strong> Ajuste por inflación del monto adeudado</li>
                    <li><strong>Restricciones:</strong> No podrás obtener tu Constancia de Situación Fiscal</li>
                    <li><strong>Bloqueo de RFC:</strong> En casos extremos, el SAT puede restringir tu RFC</li>
                </ul>
                
                <h4>Multas y Recargos</h4>
                <p><strong>Ejemplo de recargos:</strong></p>
                <div style="background: #fff3cd; padding: 15px; border-left: 4px solid #ff9800; margin: 10px 0;">
                    <p>Si debías pagar $10,000 en marzo y lo pagas en septiembre (6 meses después):</p>
                    <p>
                    Impuesto original ................ $10,000<br>
                    Recargos (aprox. 1.13% mensual) .. $678<br>
                    Actualización (inflación) ........ $320<br>
                    ─────────────────────────────────────────────<br>
                    <strong>Total a pagar: $10,998</strong>
                    </p>
                    <p>Casi $1,000 extra solo por pagar tarde.</p>
                </div>
                
                <h4>Saldo a Favor</h4>
                <p>Si pagaste más impuestos de los que debías, tienes dos opciones:</p>
                <ul>
                    <li><strong>Solicitar devolución:</strong> El SAT te regresa el dinero (tarda 40 días hábiles aprox.)</li>
                    <li><strong>Compensación:</strong> Usas ese saldo para pagar impuestos futuros</li>
                </ul>
                
                <h4>¿Cómo se presenta una declaración?</h4>
                <ol>
                    <li>Entra al portal del SAT con tu RFC y contraseña (o e.firma)</li>
                    <li>Selecciona "Presentación de declaraciones"</li>
                    <li>Llena el formulario con tus ingresos y deducciones</li>
                    <li>El sistema calcula automáticamente el impuesto</li>
                    <li>Si hay impuesto a pagar, genera la línea de captura para pagar en el banco</li>
                    <li>Recibes acuse de recibo electrónico</li>
                </ol>
                
                <h4>En AulaChain</h4>
                <p>Simularemos "declaraciones educativas" donde reportarás tus AulaChains ganados y gastados. Esto te familiariza con el proceso real de declarar ante el SAT.</p>',
                'category' => SatLesson::CATEGORY_DECLARATIONS,
                'difficulty' => SatLesson::DIFFICULTY_INTERMEDIATE,
                'estimated_minutes' => 14,
                'category_order' => 1,
                'lesson_order' => 7,
                'order' => 7,
            ],

            // ============================================
            // CATEGORÍA: E.FIRMA (NUEVO)
            // ============================================
            [
                'title' => 'Firma Electrónica (e.firma)',
                'slug' => Str::slug('Firma Electrónica (e.firma)'),
                'content' => '<h3>¿Qué es la e.firma?</h3>
                <p>La <strong>Firma Electrónica Avanzada (e.firma)</strong>, antes conocida como FIEL, es un archivo digital que funciona como tu firma autógrafa y sello personal ante el SAT y otras instituciones gubernamentales.</p>
                
                <h4>Diferencia entre RFC y e.firma</h4>
                <table border="1" cellpadding="8" style="border-collapse: collapse; width: 100%;">
                    <tr>
                        <th>Concepto</th>
                        <th>RFC</th>
                        <th>e.firma</th>
                    </tr>
                    <tr>
                        <td><strong>¿Qué es?</strong></td>
                        <td>Tu identificación fiscal (como tu nombre fiscal)</td>
                        <td>Tu firma digital (como tu firma autógrafa)</td>
                    </tr>
                    <tr>
                        <td><strong>Formato</strong></td>
                        <td>13 caracteres alfanuméricos</td>
                        <td>Archivos digitales (.cer y .key) + contraseña</td>
                    </tr>
                    <tr>
                        <td><strong>¿Quién la necesita?</strong></td>
                        <td>Todos los contribuyentes</td>
                        <td>Quien facture electrónicamente o realice trámites en línea</td>
                    </tr>
                    <tr>
                        <td><strong>Vigencia</strong></td>
                        <td>Permanente (mientras estés activo)</td>
                        <td>4 años (debe renovarse)</td>
                    </tr>
                </table>
                
                <h4>¿Para qué sirve la e.firma?</h4>
                <ul>
                    <li><strong>Facturación electrónica:</strong> Firmar digitalmente tus facturas (CFDI)</li>
                    <li><strong>Declaraciones fiscales:</strong> Presentar declaraciones mensuales y anuales</li>
                    <li><strong>Trámites en línea:</strong> Realizar trámites ante el SAT sin ir físicamente</li>
                    <li><strong>Firma de contratos:</strong> Firmar documentos legales con validez oficial</li>
                    <li><strong>Otros servicios gubernamentales:</strong> IMSS, INFONAVIT, trámites notariales, etc.</li>
                </ul>
                
                <h4>Componentes de la e.firma</h4>
                <p>La e.firma consta de tres elementos:</p>
                <ol>
                    <li><strong>Certificado (.cer):</strong> Archivo público que contiene tus datos y tu clave pública. Es como tu "credencial digital".</li>
                    <li><strong>Llave privada (.key):</strong> Archivo confidencial que solo tú debes conocer. Es como tu "firma personal".</li>
                    <li><strong>Contraseña:</strong> Código secreto para usar la llave privada (mínimo 8 caracteres).</li>
                </ol>
                
                <div style="background: #fff3cd; padding: 15px; border-left: 4px solid #ff9800; margin: 10px 0;">
                    <p><strong>⚠️ Importante:</strong> Nunca compartas tu archivo .key ni tu contraseña. Con ellos, alguien podría firmar documentos en tu nombre y comprometerte legalmente.</p>
                </div>
                
                <h4>¿Cómo se obtiene?</h4>
                <p><strong>Proceso para obtener tu e.firma:</strong></p>
                <ol>
                    <li>Genera una cita en el portal del SAT</li>
                    <li>Acude a las oficinas del SAT con:
                        <ul>
                            <li>Identificación oficial vigente</li>
                            <li>Comprobante de domicilio</li>
                            <li>USB para recibir tus archivos</li>
                        </ul>
                    </li>
                    <li>El SAT verifica tu identidad</li>
                    <li>Generas tu e.firma en el momento (en una computadora del SAT)</li>
                    <li>Recibes tus archivos .cer y .key en tu USB</li>
                    <li>Creas tu contraseña privada</li>
                </ol>
                
                <h4>Vigencia y Renovación</h4>
                <ul>
                    <li>La e.firma tiene vigencia de <strong>4 años</strong></li>
                    <li>Debes renovarla antes de que expire</li>
                    <li>El SAT te notifica 3 meses antes del vencimiento</li>
                    <li>Si vence, no podrás facturar ni presentar declaraciones hasta renovarla</li>
                </ul>
                
                <h4>Ejemplo de Uso - Facturación</h4>
                <div style="background: #f5f5f5; padding: 15px; border-left: 4px solid #2196F3; margin: 10px 0;">
                    <p><strong>Proceso de facturación con e.firma:</strong></p>
                    <ol>
                        <li>Capturas los datos de la venta en tu sistema de facturación</li>
                        <li>El sistema genera el XML de la factura</li>
                        <li>Usas tu e.firma (archivos .cer y .key + contraseña) para firmar digitalmente el XML</li>
                        <li>El sistema envía la factura firmada al SAT para su validación</li>
                        <li>El SAT asigna un Folio Fiscal (UUID) único</li>
                        <li>Entregas la factura timbrada a tu cliente</li>
                    </ol>
                    <p>Todo esto sucede en segundos y de forma automática.</p>
                </div>
                
                <h4>Seguridad de la e.firma</h4>
                <p><strong>Buenas prácticas:</strong></p>
                <ul>
                    <li>✅ Guarda tus archivos .cer y .key en un lugar seguro (USB cifrado, nube privada)</li>
                    <li>✅ Haz respaldos de tus archivos</li>
                    <li>✅ Usa una contraseña fuerte y única</li>
                    <li>✅ No compartas tu contraseña con nadie</li>
                    <li>❌ No envíes tu .key por correo electrónico</li>
                    <li>❌ No guardes tu contraseña en archivos de texto sin cifrar</li>
                </ul>
                
                <h4>¿Qué pasa si pierdo mi e.firma?</h4>
                <p>Si pierdes tus archivos o contraseña:</p>
                <ul>
                    <li><strong>Revocación:</strong> Debes revocar (cancelar) tu e.firma actual en el portal del SAT</li>
                    <li><strong>Nueva e.firma:</strong> Solicita una nueva acudiendo nuevamente a las oficinas del SAT</li>
                    <li><strong>Costo:</strong> El trámite es gratuito</li>
                </ul>
                
                <h4>e.firma vs Contraseña del SAT</h4>
                <p>No confundas la e.firma con la contraseña del portal del SAT:</p>
                <ul>
                    <li><strong>Contraseña del portal:</strong> Para entrar a tu cuenta en sat.gob.mx (trámites sencillos)</li>
                    <li><strong>e.firma:</strong> Para firmar documentos legales y realizar trámites que requieren mayor seguridad</li>
                </ul>
                
                <h4>En AulaChain</h4>
                <p>Aunque no usaremos e.firma real, entender este concepto es crucial. En el futuro, cuando empieces a facturar, la e.firma será tu herramienta principal. AulaChain te prepara para comprender su importancia y uso correcto.</p>',
                'category' => SatLesson::CATEGORY_EFIRMA,
                'difficulty' => SatLesson::DIFFICULTY_BASIC,
                'estimated_minutes' => 10,
                'category_order' => 1,
                'lesson_order' => 8,
                'order' => 8,
            ],

            // ============================================
            // CATEGORÍA: FACTURAS
            // ============================================
            [
                'title' => 'Tipos de Comprobantes Fiscales',
                'slug' => Str::slug('Tipos de Comprobantes Fiscales'),
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
                'category' => SatLesson::CATEGORY_INVOICES,
                'difficulty' => SatLesson::DIFFICULTY_BASIC,
                'estimated_minutes' => 6,
                'category_order' => 1,
                'lesson_order' => 9,
                'order' => 9,
            ],
        ];

        // Usar updateOrCreate para evitar duplicados
        foreach ($lessons as $lesson) {
            SatLesson::updateOrCreate(
                ['slug' => $lesson['slug']], // Buscar por slug único
                $lesson // Actualizar o crear con estos datos
            );
        }
    }
}
