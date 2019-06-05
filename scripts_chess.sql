/** Exibe os melhores jogadores da base de dados */

SELECT Jogador.rating, Jogador.nome FROM Jogador
ORDER BY Jogador.rating DESC

/** - - - - - - - - - */

/** Exibe o número de erros grosseiros cometidos pelo jogador */

SELECT COUNT(lance.id) AS Erros_grosseiros FROM Lance INNER JOIN
Avaliacao_lance ON Lance.id_avaliacao_lance = Avaliacao_lance.id
WHERE Avaliacao_lance.nome = 'Erro grosseiro' AND Lance.id_jogador = {{$id_jogador}}

/** - - - - - - - - - */

/** Elenca as aberturas jogadas pelo jogador, mostrando a quantidade de lances excelentes, bons, etc por abertura,
para que ele oriente-se em relação a qual abertura estudar */

SELECT Abertura.nome as Abertura, COUNT(CASE WHEN Avaliacao_lance.nome = 'Excelente' then 1 else 0 end) as Lances_excelentes,
COUNT(CASE WHEN Avaliacao_lance.nome = 'Bom' then 1 else 0 end) as Lances_bons,
COUNT(CASE WHEN Avaliacao_lance.nome = 'Imprecisão' then 1 else 0 end) as Lances_imprecisos,
COUNT(CASE WHEN Avaliacao_lance.nome = 'Erro' then 1 else 0 end) as Lances_errados,
COUNT(CASE WHEN Avaliacao_lance.nome = 'Erro grosseiro' then 1 else 0 end) as Erros_grosseiros
FROM Partida INNER JOIN Abertura ON Abertura.id = Partida.id_abertura
INNER JOIN Lance ON Lance.partida_id = Partida.id
INNER JOIN Avaliacao_lance ON Avaliacao_lance.id = Lance.id_avaliacao_lance
WHERE Lance.id_jogador = {{$id_jogador}}
ORDER BY Abertura DESC

/** - - - - - - - - - */

/** Exibe a lista dos melhores jogadores que o usuário venceu em uma partida */

SELECT Oponente.nome, Oponente.rating
FROM Partida INNER JOIN Jogador as Oponente
ON Partida.id_jogador_perdedor = Oponente.id
WHERE Partida.id_jogador_vencedor = {{$id_jogador}}
ORDER BY Oponente.rating DESC
GROUP BY Oponente.id

/** - - - - - - - - - */

/** Mostra a lista de controles de tempo mais jogados pelo jogador */

SELECT Controle_de_tempo.nome, COUNT(Partida.id) as numero_de_partidas
FROM Partida JOIN Controle_de_tempo ON Partida.id_controle_de_tempo = Controle_de_tempo.id
WHERE Partida.id_jogador_vencedor = {{$id_jogador}} OR Partida.id_jogador_perdedor = {{$id_jogador}}
ORDER BY numero_de_partidas
GROUP BY Controle_de_tempo.id

/** - - - - - - - - - */

/** Trigger que atualiza o rating dos jogadores após inserções na tabela Variacao_Rating */

DELIMITER $

CREATE OR REPLACE TRIGGER Rating_atualizacao
  AFTER INSERT ON Variacao_Rating
  FOR EACH ROW
  BEGIN
    UPDATE Jogador set rating = rating + NEW.variacao
    WHERE Jogador.id = NEW.id_jogador;
    END$

    $DELIMITER ;
