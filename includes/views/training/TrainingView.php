<div class="card mb-3">
    <div class="container padding-container-card">
        <div class="card-body">
            <h6 class="card-title fw-bold title-cards text-uppercase me-2 m-0">
                <?php echo esc_html('Gerar Treinamento'); ?>
            </h6>
            <div class="mb-3"></div>
            <form id="form-create" method="post">
                <div class="mb-5">
                    <?php if (current_user_can('coach') || current_user_can('health-pro') || current_user_can('administrator')): ?>
                    <select name="user_id" class="form-select" id="user_id">
                        <option value="">Selecione um paciente</option>
                        <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user->ID; ?>"><?php echo $user->display_name; ?></option>
                        <?php endforeach;?>
                    </select>
                    <?php endif;?>
                </div>
                <div class="mb-3">
                    <p class="mb-4 fw-bold color-secondary">Fale um pouco do Bem-estar Cerebral:</p>
                    <p class="fw-bold">Você tem dificuldade para dormir à noite?</p>
                    <select name="sleepQuality" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Sente-se cansado(a) mesmo depois de uma noite de sono completa?</p>
                    <select name="sleepQuality" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você acorda no meio da noite e tem dificuldade para voltar a dormir?</p>
                    <select name="sleepQuality" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Sente-se sonolento(a) ou sem energia durante o dia?</p>
                    <select name="sleepQuality" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem sonhos ou pesadelos que interrompem seu sono?</p>
                    <select name="sleepQuality" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você se sente mentalmente exausto(a) no final do dia?</p>
                    <select name="mentalFatigue" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade para tomar decisões ou resolver problemas quando está
                        cansado(a)?</p>
                    <select name="mentalFatigue" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente que precisa de um tempo para "recarregar" depois de atividades
                        mentalmente exigentes?</p>
                    <select name="mentalFatigue" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente que sua energia mental diminui ao longo do dia?</p>
                    <select name="mentalFatigue" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade para se concentrar ou pensar claramente quando está
                        cansado(a)?</p>
                    <select name="mentalFatigue" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente que sua mente e seu corpo não estão em sincronia?</p>
                    <select name="perceptionMindBody" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente que não tem controle sobre seu corpo?</p>
                    <select name="perceptionMindBody" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente que seu corpo não responde às suas ações ou intenções como você
                        gostaria?</p>
                    <select name="perceptionMindBody" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Sente-se frequentemente ansioso(a) ou preocupado(a)?
                    </p>
                    <select name="controlofAnxiety" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Sente que sua ansiedade é difícil de controlar?
                    </p>
                    <select name="controlofAnxiety" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Sente-se frequentemente inquieto(a) ou nervoso(a)?
                    </p>
                    <select name="controlofAnxiety" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você se preocupa exageradamente com coisas diferentes?
                    </p>
                    <select name="controlofAnxiety" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Sente medo ou pânico sem motivo aparente?
                    </p>
                    <select name="controlofAnxiety" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Sente que suas emoções estão fora de controle?
                    </p>
                    <select name="emotionalControl" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem mudanças bruscas de humor?
                    </p>
                    <select name="emotionalControl" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Sente-se frequentemente dominado(a) por suas emoções?
                    </p>
                    <select name="emotionalControl" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade para se acalmar depois de se sentir irritado(a) ou
                        agitado(a)?
                    </p>
                    <select name="emotionalControl" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Sente que não consegue controlar sua raiva ou a deixa dominar?
                    </p>
                    <select name="emotionalControl" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente que está sob muito estresse?
                    </p>
                    <select name="stress" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade para relaxar ou descomprimir?
                    </p>
                    <select name="stress" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você se sente constantemente sofrendo pela falta de tempo?
                    </p>
                    <select name="stress" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você se sente sobrecarregado(a) por suas responsabilidades?
                    </p>
                    <select name="stress" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente que o estresse está afetando sua saúde física ou mental?
                    </p>
                    <select name="stress" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente dores no corpo regularmente?
                    </p>
                    <select name="bodyPain" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Suas dores no corpo limitam suas atividades diárias?
                    </p>
                    <select name="bodyPain" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente dor em mais de uma área do corpo?
                    </p>
                    <select name="bodyPain" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Sua dor no corpo piora em situações de estresse ou ansiedade?
                    </p>
                    <select name="bodyPain" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente dores no corpo que não parecem ter uma causa física clara?
                    </p>
                    <select name="bodyPain" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sofre de dores de cabeça frequentes?
                    </p>
                    <select name="headache" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">As dores de cabeça tiram sua capacidade de funcionar normalmente?
                    </p>
                    <select name="headache" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você experimenta dores de cabeça após períodos de estresse mental ou físico
                        intenso?
                    </p>
                    <select name="headache" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">As dores de cabeça são geralmente várias ou debilitantes?
                    </p>
                    <select name="headache" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">As dores de cabeça vêm acompanhadas de outros sintomas, como náuseas ou
                        sensibilidade à luz?
                    </p>
                    <select name="headache" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente ansiedade ou medo irracional de certos objetos, lugares ou situações?
                    </p>
                    <select name="stimuliAnxiety" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você evita certas situações ou atividades por causa da ansiedade que elas causam?
                    </p>
                    <select name="stimuliAnxiety" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente ansiedade em situações sociais ou ao conhecer novas pessoas?
                    </p>
                    <select name="stimuliAnxiety" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente um aumento na ansiedade ou no estresse em resposta a certos filhos,
                        luzes ou sensações táteis?
                    </p>
                    <select name="stimuliAnxiety" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem pensamentos negativos que parecem incontroláveis?
                    </p>
                    <select name="thoughtsInvasive" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você se preocupa constantemente com coisas que poderiam dar errado?
                    </p>
                    <select name="thoughtsInvasive" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade em parar de pensar em algo uma vez que começa?
                    </p>
                    <select name="thoughtsInvasive" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente que seus pensamentos são invasivos e interrompem sua concentração?
                    </p>
                    <select name="thoughtsInvasive" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade em controlar sua raiva ou está deixando você?
                    </p>
                    <select name="thoughtsInvasive" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="mb-4 fw-bold color-secondary">Fale um pouco do Desempenho Cognitivo:</p>
                    <p class="fw-bold">Sente que sua mente está sempre "a mil"?</p>
                    <select name="mentalActivity" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você se sente incapaz de desligar
                        seus pensamentos?</p>
                    <select name="mentalActivity" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você se sente mentalmente
                        exausto(a) no final do dia?</p>
                    <select name="mentalActivity" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade para relaxar
                        sua mente?</p>
                    <select name="mentalActivity" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade em manter
                        seus pensamentos organizados?</p>
                    <select name="mentalActivity" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você se distrai facilmente?</p>
                    <select name="concentration" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade em se concentrar em tarefas que não são de seu interesse?
                    </p>
                    <select name="concentration" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você se perde em seus pensamentos quando deveria estar focado(a) em algo?</p>
                    <select name="concentration" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade em manter a atenção em conversas ou leituras?</p>
                    <select name="concentration" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você comete erros por falta de
                        concentração?</p>
                    <select name="concentration" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você se sente menos criativo(a) do
                        que gostaria de ser?</p>
                    <select name="creativity" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade em gerar
                        novas ideias?</p>
                    <select name="creativity" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente que perdeu sua paixão
                        ou curiosidade pela vida?</p>
                    <select name="creativity" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente que está preso(a) em uma rotina e não consegue
                        encontrar uma saída?</p>
                    <select name="creativity" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente que seus pensamentos são repetitivos e sem inspiração?</p>
                    <select name="creativity" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você se distrai facilmente quando tenta focar em algo?</p>
                    <select name="focusAndAttention" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade para completar tarefas que permaneceram atentas
                        continuamente?</p>
                    <select name="focusAndAttention" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade para manter o foco em reuniões ou durante
                        conversas longas?</p>
                    <select name="focusAndAttention" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente que precisa de mais esforço do que os outros para
                        manter o foco?</p>
                    <select name="focusAndAttention" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você perde o interesse em tarefas
                        longas ou complexas?</p>
                    <select name="focusAndAttention" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você se esquece de coisas
                        facilmente?</p>
                    <select name="learningAndMemory" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade em lembrar de detalhes ou informações
                        importantes?</p>
                    <select name="learningAndMemory" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você tem dificuldade em aprender novos conceitos ou habilidades?</p>
                    <select name="learningAndMemory" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você sente que sua memória está
                        piorando?</p>
                    <select name="learningAndMemory" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                    <p class="fw-bold">Você esquece coisas que aprendeu
                        recentemente?</p>
                    <select name="learningAndMemory" class="form-select mb-4">
                        <option>Selecione uma resposta</option>
                        <option value="1">Nunca</option>
                        <option value="2">Raramente</option>
                        <option value="3">Às vezes</option>
                        <option value="4">Quase Sempre</option>
                        <option value="5">Sempre</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Gerar Treinamento</button>
            </form>
        </div>
    </div>
</div>