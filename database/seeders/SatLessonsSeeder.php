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
                'quiz_data' => [
                    'questions' => [
                        [
                            'question' => '¿Qué significan las siglas SAT?',
                            'options' => [
                                'Servicio de Administración de Tareas',
                                'Servicio de Administración Tributaria',
                                'Sistema de Apoyo a Trabajadores'
                            ],
                            'correct_answer' => 1 // índice de la respuesta correcta (0-based)
                        ],
                        [
                            'question' => '¿Para qué recolecta impuestos el gobierno?',
                            'options' => [
                                'Para construir carreteras, escuelas y hospitales',
                                'Para guardarlos en un banco gigante',
                                'Para pagar viajes espaciales'
                            ],
                            'correct_answer' => 0
                        ],
                        [
                            'question' => 'Es una obligación del SAT:',
                            'options' => [
                                'Repartir dulces en la escuela',
                                'Emitir y administrar el RFC',
                                'Vender automóviles'
                            ],
                            'correct_answer' => 1
                        ]
                    ]
                ]
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
                'quiz_data' => [
                    'questions' => [
                        [
                            'question' => '¿Qué principio significa "Declarar correctamente tus ingresos"?',
                            'options' => ['Puntualidad', 'Honestidad', 'Creatividad'],
                            'correct_answer' => 1
                        ],
                        [
                            'question' => '¿Cumplir con los impuestos beneficia solo a los demás o a ti también?',
                            'options' => ['Solo a los demás', 'Solo a mí', 'A todos, incluyendo a mí'],
                            'correct_answer' => 2
                        ],
                        [
                            'question' => 'Si eres responsable en AulaChain, ¿qué obtienes?',
                            'options' => ['Castigos sorpresa', 'Reconocimientos y beneficios', 'Nada'],
                            'correct_answer' => 1
                        ]
                    ]
                ]
            ],
            [
                'title' => '¿Qué es el Ahorro vs el Pago de Impuestos?',
                'slug' => Str::slug('¿Qué es el Ahorro vs el Pago de Impuestos?'),
                'content' => '<h3>El Sueldo y las Alcancías</h3>
                <p>Imagina que recibes tu primer "sueldo" por terminar todas tus tareas. Ese monto total se llama <strong>Sueldo Bruto</strong> (todo completito sin que nadie lo toque).</p>
                <p>En la vida real (y en AulaChain), el dinero que ganas no se gasta completo de inmediato. Un buen contribuyente aprende a separar su Sueldo Bruto en 3 "alcancías" diferentes:</p>
                
                <h4>Alcancía 1: El Gasto de Hoy (Ingreso Neto)</h4>
                <p>Este es el dinero que te queda para usar HOY. Puedes comprar en la tiendita escolar, canjear recompensas o usarlo en lo que necesites ahora mismo.</p>

                <h4>Alcancía 2: El Impuesto (Fondo de la Clase)</h4>
                <p>Esta es tu aportación. Un porcentaje de tu sueldo bruto debe ir al SAT (o en tu caso, al Fondo de la Clase). Este dinero no es tuyo, es de la comunidad. Se usa para beneficio de todos, como comprar pizzas para el salón a final de mes.</p>

                <h4>Alcancía 3: El Ahorro del Mañana</h4>
                <p>¡Esta es la alcancía más importante para tu futuro! De lo que te queda para gastar (ingreso neto), lo ideal es apartar una parte para guardarla y usarla más adelante en algo más grande, como un premio muy caro.</p>
                
                <h4>En Resumen:</h4>
                <div style="background: #e8f5e9; padding: 15px; border-left: 4px solid #4CAF50; margin: 10px 0;">
                    <strong>Sueldo Bruto</strong> - <strong>Impuesto</strong> = <strong>Sueldo Neto</strong><br>
                    <strong>Sueldo Neto</strong> = <strong>Gasto</strong> + <strong>Ahorro</strong>
                </div>',
                'category' => SatLesson::CATEGORY_GENERAL,
                'difficulty' => SatLesson::DIFFICULTY_BASIC,
                'estimated_minutes' => 7,
                'category_order' => 3,
                'lesson_order' => 3,
                'order' => 3,
                'quiz_data' => [
                    'questions' => [
                        [
                            'question' => '¿Cómo se le llama al dinero total que ganas antes de cualquier descuento?',
                            'options' => ['Sueldo Neto', 'Sueldo Bruto', 'Ahorro'],
                            'correct_answer' => 1
                        ],
                        [
                            'question' => '¿Para qué sirve la segunda alcancía, el Impuesto?',
                            'options' => ['Para gastarlo todo hoy en dulces', 'Para el beneficio de toda la comunidad', 'Para esconderlo debajo del colchón'],
                            'correct_answer' => 1
                        ],
                        [
                            'question' => '¿Qué significa el "Sueldo Neto"?',
                            'options' => ['Lo que te queda después de pagar el impuesto', 'Todo el dinero que ganaste en el mes', 'El dinero que donas al salón'],
                            'correct_answer' => 0
                        ]
                    ]
                ]
            ],
            [
                'title' => 'El Presupuesto Personal',
                'slug' => Str::slug('El Presupuesto Personal'),
                'content' => '<h3>¿Cómo administrar tus AulaChains?</h3>
                <p>Un presupuesto es un plan que haces con tu dinero. Una vez que ya pagaste tus impuestos (ya contribuiste al salón), ¡ahora eres el dueño y jefe de tus AulaChains!</p>

                <h4>Regla del 50/30/20</h4>
                <p>Esta es una regla mágica muy usada por adultos para que el dinero alcance:</p>
                <ul>
                    <li><strong>50% Necesidades:</strong> Lo que a fuerza tienes que pagar. (En la vida real: comida, renta. En la escuela: comprar material si se te olvidó, pagar multas por no hacer la tarea).</li>
                    <li><strong>30% Deseos:</strong> Lo que te divierte. (Dulces extra, stickers, recompensas de juego).</li>
                    <li><strong>20% Ahorro:</strong> Dinero que guardas para el futuro, para estar seguro o comprar ese premio legendario de fin de año.</li>
                </ul>

                <h4>¿Cómo hacer un presupuesto?</h4>
                <ol>
                    <li>Anota cuánto ganas (Ingresos).</li>
                    <li>Anota tus gastos forzosos (Lápices, multas).</li>
                    <li>Anota tus metas de ahorro (Quiero 500 AC para el Pase VIP al final del bimestre).</li>
                    <li>Anota cuánto vas a gastar en cosas divertidas.</li>
                </ol>',
                'category' => SatLesson::CATEGORY_GENERAL,
                'difficulty' => SatLesson::DIFFICULTY_INTERMEDIATE,
                'estimated_minutes' => 8,
                'category_order' => 4,
                'lesson_order' => 4,
                'order' => 4,
                'quiz_data' => [
                    'questions' => [
                        [
                            'question' => '¿Para qué sirve hacer un presupuesto?',
                            'options' => ['Para hacer un plan con tu dinero y que te alcance', 'Para que te cobren más impuestos', 'Para regalárselo al maestro'],
                            'correct_answer' => 0
                        ],
                        [
                            'question' => 'Según la regla 50/30/20, ¿cuánto debes intentar ahorrar?',
                            'options' => ['0%', '50%', '20%'],
                            'correct_answer' => 2
                        ],
                        [
                            'question' => 'Comprar dulces o cosas divertidas entra en la categoría de:',
                            'options' => ['Ahorros', 'Deseos', 'Necesidades forzosas'],
                            'correct_answer' => 1
                        ]
                    ]
                ]
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
                'lesson_order' => 5,
                'order' => 5,
                'quiz_data' => [
                    'questions' => [
                        [
                            'question' => '¿Cuántos caracteres tiene normalmente el RFC de una persona moral o física (máximo)?',
                            'options' => ['10 caracteres', '13 caracteres', '20 caracteres'],
                            'correct_answer' => 1
                        ],
                        [
                            'question' => '¿Qué son los últimos 3 caracteres del RFC?',
                            'options' => ['La homoclave', 'Las iniciales secretas', 'El año de nacimiento'],
                            'correct_answer' => 0
                        ],
                        [
                            'question' => 'El RFC te sirve para:',
                            'options' => ['Entrar al cine', 'Identificarte en todas tus actividades económicas', 'Jugar videojuegos online'],
                            'correct_answer' => 1
                        ]
                    ]
                ]
            ],

            // ============================================
            // CATEGORÍA: REGÍMENES FISCALES
            // ============================================
            [
                'title' => '¿Qué es un Régimen Fiscal?',
                'slug' => Str::slug('¿Qué es un Régimen Fiscal?'),
                'content' => '<h3>Regímenes Fiscales en México</h3>
                <p>Un <strong>régimen fiscal</strong> es el conjunto de derechos y obligaciones que tienes ante el SAT según tu tipo de actividad económica. Determina cómo calculas y pagas tus impuestos.</p>
                
                <h4>Persona Física vs Persona Moral</h4>
                <p><strong>Persona Física:</strong> Eres tú como individuo. Trabajas, prestas servicios o tienes un negocio a tu nombre.</p>
                <p><strong>Persona Moral:</strong> Es una empresa o sociedad. Tiene personalidad jurídica propia, separada de sus socios.</p>
                
                <h4>Principales Regímenes para Personas Físicas</h4>
                <ul>
                    <li><strong>Sueldos y Salarios:</strong> Trabajas para alguien más y recibes nómina.</li>
                    <li><strong>RESICO:</strong> Para pequeños negocios con ingresos de hasta $3.5 millones.</li>
                    <li><strong>Actividad Empresarial y Profesional:</strong> Negocios más grandes o profesionistas (doctores).</li>
                </ul>',
                'category' => SatLesson::CATEGORY_REGIMES,
                'difficulty' => SatLesson::DIFFICULTY_INTERMEDIATE,
                'estimated_minutes' => 12,
                'category_order' => 1,
                'lesson_order' => 6,
                'order' => 6,
                'quiz_data' => [
                    'questions' => [
                        [
                            'question' => 'Una persona física es:',
                            'options' => ['Una empresa gigante', 'Tú como individuo', 'Una corporación internacional'],
                            'correct_answer' => 1
                        ],
                        [
                            'question' => 'Si trabajas para alguien más y te pagan por nómina, estás en el régimen de:',
                            'options' => ['Actividad Empresarial', 'Sueldos y Salarios', 'RESICO'],
                            'correct_answer' => 1
                        ],
                        [
                            'question' => 'Una empresa o corporación está considerada como:',
                            'options' => ['Persona moral', 'Persona mágica', 'Persona física'],
                            'correct_answer' => 0
                        ]
                    ]
                ]
            ],

            // ============================================
            // CATEGORÍA: IMPUESTOS
            // ============================================
            [
                'title' => '¿Por qué pagamos impuestos?',
                'slug' => Str::slug('¿Por qué pagamos impuestos?'),
                'content' => '<h3>La Importancia de los Impuestos</h3>
                <p>Los impuestos son la forma en que la sociedad financia los servicios públicos que todos necesitamos.</p>
                
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
                'lesson_order' => 7,
                'order' => 7,
                'quiz_data' => [
                    'questions' => [
                        [
                            'question' => '¿Los impuestos ayudan a construir qué cosas?',
                            'options' => ['Casas privadas', 'Escuelas, hospitales y carreteras', 'Carros de lujo'],
                            'correct_answer' => 1
                        ],
                        [
                            'question' => 'Si nadie pagara impuestos, ¿qué sucedería con los servicios públicos?',
                            'options' => ['Aumentarían su calidad', 'Se mantendrían igual', 'No habría dinero para mantenerlos y desaparecerían'],
                            'correct_answer' => 2
                        ],
                        [
                            'question' => 'En el sistema de tu escuela, ¿cuál es el equivalente de los "impuestos"?',
                            'options' => ['El ahorro', 'El Fondo Común de la Clase', 'Los dulces de la tiendita'],
                            'correct_answer' => 1
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Principales Impuestos en México',
                'slug' => Str::slug('Principales Impuestos en México'),
                'content' => '<h3>Los Tres Impuestos Principales</h3>
                <p>En México, los impuestos más importantes que debes conocer son: ISR, IVA e IEPS.</p>
                
                <h4>ISR - Impuesto Sobre la Renta</h4>
                <p>El ISR grava tus <strong>ingresos</strong>. Es decir, pagas un porcentaje de lo que ganas. Quien gana más, paga un porcentaje mayor.</p>
                
                <h4>IVA - Impuesto al Valor Agregado</h4>
                <p>El IVA grava el <strong>consumo</strong>. La tasa general es el <strong>16%</strong>. Se aplica cuando compras o vendes productos y servicios.</p>
                
                <h4>IEPS - Impuesto Especial sobre Producción y Servicios</h4>
                <p>El IEPS es un impuesto adicional para productos específicos, como la gasolina, bebidas azucaradas, o cigarros, para desincentivar su consumo.</p>',
                'category' => SatLesson::CATEGORY_TAXES,
                'difficulty' => SatLesson::DIFFICULTY_INTERMEDIATE,
                'estimated_minutes' => 10,
                'category_order' => 2,
                'lesson_order' => 8,
                'order' => 8,
                'quiz_data' => [
                    'questions' => [
                        [
                            'question' => '¿Cuál de estos impuestos se cobra al CONSUMO, es decir, cuando compras algo?',
                            'options' => ['ISR', 'IVA', 'Ambos'],
                            'correct_answer' => 1
                        ],
                        [
                            'question' => '¿Cuál impuesto grava directamente el dinero que GANAS a través de tu sueldo o ingresos libres?',
                            'options' => ['ISR', 'IVA', 'IEPS'],
                            'correct_answer' => 0
                        ],
                        [
                            'question' => 'Si compras un refresco o gasolina, además del IVA podrías estar pagando:',
                            'options' => ['Tenencia', 'IEPS', 'ISR'],
                            'correct_answer' => 1
                        ]
                    ]
                ]
            ],

            // ============================================
            // CATEGORÍA: DECLARACIONES
            // ============================================
            [
                'title' => '¿Qué es una Declaración Fiscal?',
                'slug' => Str::slug('¿Qué es una Declaración Fiscal?'),
                'content' => '<h3>Declaraciones Fiscales</h3>
                <p>Una <strong>declaración fiscal</strong> es el documento oficial donde informas al SAT cuánto ganaste, cuánto gastaste y cuánto impuesto debes pagar en un periodo determinado.</p>
                
                <h4>Tipos de Declaraciones</h4>
                <ul>
                    <li><strong>Mensual:</strong> Se presenta cada mes informando los ingresos del mes anterior.</li>
                    <li><strong>Anual:</strong> Resume todo el año fiscal. Aquí puedes aplicar deducciones personales. Si pagaste de más, puedes obtener "saldo a favor" (devolución).</li>
                </ul>
                
                <h4>¿Qué incluye una declaración?</h4>
                <ul>
                    <li><strong>Ingresos:</strong> Todo lo ganaste.</li>
                    <li><strong>Deducciones:</strong> Gastos permitidos a tu favor.</li>
                    <li><strong>Impuesto a cargo:</strong> Lo que quedas a deber.</li>
                    <li><strong>Saldo a favor:</strong> Lo que te devolverán.</li>
                </ul>',
                'category' => SatLesson::CATEGORY_DECLARATIONS,
                'difficulty' => SatLesson::DIFFICULTY_INTERMEDIATE,
                'estimated_minutes' => 12,
                'category_order' => 1,
                'lesson_order' => 9,
                'order' => 9,
                'quiz_data' => [
                    'questions' => [
                        [
                            'question' => '¿Qué es una declaración fiscal?',
                            'options' => ['Un poema para el SAT', 'Un reporte donde informas tus ingresos, gastos e impuestos', 'Una carta para conseguir trabajo'],
                            'correct_answer' => 1
                        ],
                        [
                            'question' => 'Si pagaste más impuestos de los que debías durante el año, obtienes un:',
                            'options' => ['Saldo Nulo', 'Saldo en contra', 'Saldo a favor'],
                            'correct_answer' => 2
                        ],
                        [
                            'question' => '¿Existen declaraciones mensuales y también anuales?',
                            'options' => ['Solo existen mensuales', 'Sí, existen mensuales y anuales', 'Solo existen anuales'],
                            'correct_answer' => 1
                        ]
                    ]
                ]
            ],
            [
                'title' => 'El lado bueno: Las Deducciones (Cómo recuperar dinero)',
                'slug' => Str::slug('El lado bueno: Las Deducciones (Cómo recuperar dinero)'),
                'content' => '<h3>Las Deducciones Personales</h3>
                <p>Seguro escuchaste "pago de impuestos" y te asustaste un poco. Pero ¿sabías que el SAT puede <strong>"premiarte"</strong> y regresarte dinero?</p>
                
                <h4>¿Qué son las deducciones?</h4>
                <p>Una deducción es un gasto "bueno" que las leyes te permiten restar a los ingresos de todo el año, lo cual significa que tu "Sueldo Imponible" (al que le cobran impuestos) se hace más pequeño, ¡por tanto, te regresan una parte del impuesto que pagaste mes a mes!</p>

                <h4>¿Qué gastos te premia el SAT?</h4>
                <p>No cuenta comprar videojuegos o dulces. El SAT deduce rubros que apoyan la calidad de vida e inversiones inteligentes, tales como:</p>
                <ul>
                    <li><strong>Salud:</strong> Citas con el doctor, dentista, psicólogo o nutriólogo. Gastos médicos importantes y lentes con graduación.</li>
                    <li><strong>Educación:</strong> Colegiaturas de escuelas, transporte escolar (a veces).</li>
                    <li><strong>Ahorros para el Retiro:</strong> Aportaciones extras que pones en tu AFORE de manera voluntaria para cuando seas un abuelito y decidas descansar.</li>
                </ul>

                <h4>La regla de oro de las Deducciones:</h4>
                <p>Para que un gasto cuente, debes siempre: <strong>¡PAGAR CON TARJETA (o transferencia)! ¡Y pedir tu Factura (CFDI)!</strong> Si pagas en efectivo y no pides factura, ¡no cuenta para el premio al final del año!</p>',
                'category' => SatLesson::CATEGORY_DECLARATIONS,
                'difficulty' => SatLesson::DIFFICULTY_INTERMEDIATE,
                'estimated_minutes' => 9,
                'category_order' => 2,
                'lesson_order' => 10,
                'order' => 10,
                'quiz_data' => [
                    'questions' => [
                        [
                            'question' => '¿Qué es una "deducción"?',
                            'options' => ['Un impuesto sorpresa', 'Un gasto permitido que ayuda a reducir los impuestos que debes pagar', 'Un castigo del gobierno'],
                            'correct_answer' => 1
                        ],
                        [
                            'question' => '¿Cuál de estos gastos ES DEDUCIBLE (te ayuda con el SAT)?',
                            'options' => ['Ir al cine', 'Comprar una cámara fotográfica', 'Ir al dentista y pedir factura'],
                            'correct_answer' => 2
                        ],
                        [
                            'question' => '¿Qué debes hacer obligatoriamente para deducir un gasto médico?',
                            'options' => ['Pagar en eféctivo y no pedir recibo', 'Pagar con tarjeta/transferencia y pedir Factura', 'Decirle al doctor que es un secreto'],
                            'correct_answer' => 1
                        ]
                    ]
                ]
            ],

            // ============================================
            // CATEGORÍA: CULTURA DE LA LEGALIDAD Y ÉTICA
            // ============================================
            [
                'title' => 'Economía Formal vs Informal (Jugando limpio)',
                'slug' => Str::slug('Economía Formal vs Informal (Jugando limpio)'),
                'content' => '<h3>¿Jugamos limpio? Formalidad vs Informalidad</h3>
                <p>Quizá hayas notado en la calle que existen tiendas muy grandes, y puestos pequeños improvisados en la banqueta. Algunas de estas diferencias ilustran dos tipos de economía.</p>
                
                <h4>La Economía Formal</h4>
                <p>La economía formal existe cuando las empresas o personas tienen su RFC, están dadas de alta en el SAT, declaran lo que ganan y pagan los impuestos correspondientes.</p>
                <ul>
                    <li>Tienen facturas de todo.</li>
                    <li>Contribuyen al fondo para arreglar calles y construir escuelas.</li>
                    <li>Los trabajadores tienen seguro (IMSS).</li>
                    <li>Si ganan mucho, todos en el país salen beneficiados por la porción de sus impuestos.</li>
                </ul>

                <h4>La Economía Informal</h4>
                <p>La informalidad son las personas o pequeños negocios que reciben pagos "a escondidas" (solo efectivo), nunca se dieron de alta en el SAT y no pagan impuestos de ese ingreso.</p>
                <ul>
                    <li>Ellos utilizan la pavimentación de la ciudad y la seguridad pública... pero no están ayudando a pagarla.</li>
                    <li>Si tienen una emergencia, podrían no tener acceso a la seguridad del estado.</li>
                </ul>

                <h4>El ejemplo con los AulaChains</h4>
                <p>Un trueque a escondidas en el que le compras una pluma a tu compañero con AulaChains pasándose las cuentas de forma trampa (y no pagando el 5% que requiere el sistema de transferencias), le quita recursos a la clase. Esos recursos del fondo de la clase eran para comprar esa gran pizza al final de año. Si todos hacemos transferencias a escondidas, <strong>todos nos quedamos con las manos vacías</strong>. ¡Hacerlo por la vía correcta, nos beneficia a todos!</p>',
                'category' => SatLesson::CATEGORY_GENERAL,
                'difficulty' => SatLesson::DIFFICULTY_INTERMEDIATE,
                'estimated_minutes' => 9,
                'category_order' => 5,
                'lesson_order' => 11,
                'order' => 11,
                'quiz_data' => [
                    'questions' => [
                        [
                            'question' => 'Una empresa de economía Formal paga impuestos. ¿Es esto cierto?',
                            'options' => ['Falso', 'Solo los domingos', 'Cierto, porque están dados de alta en el SAT y tienen RFC'],
                            'correct_answer' => 2
                        ],
                        [
                            'question' => '¿Qué problema tiene la economía informal?',
                            'options' => ['Ayuda mucho al país', 'Utilizan los beneficios del país o salón sin ayudar a pagarlos', 'Pagan demasiados impuestos juntos'],
                            'correct_answer' => 1
                        ],
                        [
                            'question' => 'Hacer "trueques a escondidas" en la escuela con AulaChains es perjudicial porque:',
                            'options' => ['Reducen el fondo de grupo para premios colectivos', 'Hacen que la maestra esté feliz', 'Aumentan las vacaciones'],
                            'correct_answer' => 0
                        ]
                    ]
                ]
            ],

            // ============================================
            // CATEGORÍA: E.FIRMA
            // ============================================
            [
                'title' => 'Firma Electrónica (e.firma)',
                'slug' => Str::slug('Firma Electrónica (e.firma)'),
                'content' => '<h3>¿Qué es la e.firma?</h3>
                <p>La <strong>Firma Electrónica Avanzada (e.firma)</strong>, antes conocida como FIEL, es un archivo digital que funciona como tu firma autógrafa y sello personal ante el SAT y otras instituciones gubernamentales.</p>
                
                <h4>¿Para qué sirve la e.firma?</h4>
                <ul>
                    <li><strong>Facturación electrónica:</strong> Firmar digitalmente tus facturas (CFDI)</li>
                    <li><strong>Declaraciones fiscales:</strong> Presentar declaraciones mensuales y anuales</li>
                    <li><strong>Trámites en línea:</strong> Realizar trámites ante el SAT sin ir físicamente</li>
                </ul>
                
                <h4>Componentes de la e.firma</h4>
                <p>La e.firma consta de tres elementos:</p>
                <ol>
                    <li><strong>Certificado (.cer):</strong> Archivo público que contiene tus datos.</li>
                    <li><strong>Llave privada (.key):</strong> Archivo confidencial que solo tú debes conocer.</li>
                    <li><strong>Contraseña:</strong> Código secreto para abrir el archivo.</li>
                </ol>
                
                <div style="background: #fff3cd; padding: 15px; border-left: 4px solid #ff9800; margin: 10px 0;">
                    <p><strong>⚠️ Importante:</strong> Nunca compartas tu archivo .key ni tu contraseña. Con ellos, alguien podría firmar documentos en tu nombre y comprometerte legalmente.</p>
                </div>',
                'category' => SatLesson::CATEGORY_EFIRMA,
                'difficulty' => SatLesson::DIFFICULTY_BASIC,
                'estimated_minutes' => 10,
                'category_order' => 1,
                'lesson_order' => 12,
                'order' => 12,
                'quiz_data' => [
                    'questions' => [
                        [
                            'question' => '¿Qué valor legal tiene tu e.firma?',
                            'options' => ['Tiene la misma validez que firmar algo con tu puño y letra', 'No sirve para nada', 'Sirve como un sticker decorativo'],
                            'correct_answer' => 0
                        ],
                        [
                            'question' => '¿A quién deberías entregarle tu archivo Llave Privada (.key) y contraseña?',
                            'options' => ['A todos mis amigos', 'A nadie, son completamente confidenciales y solo tuyos', 'A cualquier persona que me lo pida en Internet'],
                            'correct_answer' => 1
                        ],
                        [
                            'question' => '¿Para qué utilizas principalmente la e.firma?',
                            'options' => ['Para abrir puertas automáticas', 'Para firmar facturas electrónicas y declaraciones fiscales en línea', 'Para registrarte en Netflix'],
                            'correct_answer' => 1
                        ]
                    ]
                ]
            ],

            // ============================================
            // CATEGORÍA: FACTURAS
            // ============================================
            [
                'title' => 'Tipos de Comprobantes Fiscales',
                'slug' => Str::slug('Tipos de Comprobantes Fiscales'),
                'content' => '<h3>Comprobantes Fiscales Digitales</h3>
                <p>Los comprobantes fiscales son documentos que acreditan una operación comercial. En México el más importante se llama CFDI.</p>
                
                <h4>Factura Electrónica (CFDI)</h4>
                <p>Es el comprobante más común. Debe incluir:</p>
                <ul>
                    <li>Datos del emisor (nombre, RFC, dirección de quien vende)</li>
                    <li>Datos del receptor (nombre, RFC de quien compra)</li>
                    <li>Concepto de la operación</li>
                    <li>Monto y desglose de impuestos</li>
                    <li>Folio fiscal único (UUID) y Código QR</li>
                </ul>
                
                <h4>En AulaChain</h4>
                <p>Cuando canjeas una recompensa, recibes una "Factura Digital Educativa" que simula el formato real. Esto te ayuda a entender cómo funcionan los comprobantes fiscales en la vida real.</p>',
                'category' => SatLesson::CATEGORY_INVOICES,
                'difficulty' => SatLesson::DIFFICULTY_BASIC,
                'estimated_minutes' => 6,
                'category_order' => 1,
                'lesson_order' => 13,
                'order' => 13,
                'quiz_data' => [
                    'questions' => [
                        [
                            'question' => '¿Qué son las siglas CFDI?',
                            'options' => ['Comprobante Fiscal Digital por Internet', 'Códigos Falsos De Investigación', 'Caja Fuerte Dinero Ilimitado'],
                            'correct_answer' => 0
                        ],
                        [
                            'question' => '¿Un CFDI o Factura debe incluir el RFC de quién compra y también de quién vende?',
                            'options' => ['No, solo importa la cantidad de dinero', 'Sí, siempre incluye los RFC de ambas partes', 'Los tickets del súper mercados los tienen'],
                            'correct_answer' => 1
                        ],
                        [
                            'question' => '¿Qué es el UUID?',
                            'options' => ['Un tipo de sándwich', 'El Folio Fiscal único e irrepetible para identificar la factura', 'La foto del vendedor'],
                            'correct_answer' => 1
                        ]
                    ]
                ]
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
